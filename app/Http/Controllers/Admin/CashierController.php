<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN KASIR
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $products = Product::where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        $heldTransactions = Transaction::where('status', 'held')
            ->with('details')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.cashier.index', compact(
            'products',
            'heldTransactions'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH PRODUCT
    |--------------------------------------------------------------------------
    */

    public function searchProduct(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::where('name', 'like', '%' . $keyword . '%')
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return response()->json($products);
    }


    /*
    |--------------------------------------------------------------------------
    | TAHAN TRANSAKSI
    |--------------------------------------------------------------------------
    */

    /*
|--------------------------------------------------------------------------
| TAHAN TRANSAKSI
|--------------------------------------------------------------------------
*/

public function hold(Request $request)
{
    $validated = $request->validate([
        'transaction_id' => [
            'nullable',
            'integer',
            'exists:transactions,id'
        ],

        'items' => [
            'required',
            'array',
            'min:1'
        ],

        'items.*.id' => [
            'required',
            'integer',
            'exists:products,id'
        ],

        'items.*.qty' => [
            'required',
            'integer',
            'min:1'
        ],

        'discount' => [
            'nullable',
            'numeric',
            'min:0'
        ],

        'tax' => [
            'nullable',
            'numeric',
            'min:0'
        ],

        'other_fee' => [
            'nullable',
            'numeric',
            'min:0'
        ],
    ]);

    try {

        $transaction = DB::transaction(function () use ($validated) {

            $subtotal = 0;
            $items = [];

            /*
             * Ambil data produk dari database.
             * Saat transaksi ditahan, stok TIDAK dikurangi.
             */
            foreach ($validated['items'] as $item) {

                $product = Product::findOrFail($item['id']);

                $qty = (int) $item['qty'];

                $itemSubtotal =
                    (float) $product->price * $qty;

                $subtotal += $itemSubtotal;

                $items[] = [
                    'product' => $product,
                    'qty' => $qty,
                    'subtotal' => $itemSubtotal,
                ];
            }

            /*
             * Ambil nilai tambahan transaksi
             */
            $discount = (float) (
                $validated['discount'] ?? 0
            );

            $tax = (float) (
                $validated['tax'] ?? 0
            );

            $otherFee = (float) (
                $validated['other_fee'] ?? 0
            );

            /*
             * Hitung total
             */
            $grandTotal = max(
                0,
                $subtotal
                - $discount
                + $tax
                + $otherFee
            );

            /*
             * Cek apakah ini transaksi lama
             * yang sebelumnya sudah ditahan.
             */
            $transactionId =
                $validated['transaction_id'] ?? null;

            if ($transactionId) {

                $transaction = Transaction::where(
                    'id',
                    $transactionId
                )
                    ->where('status', 'held')
                    ->lockForUpdate()
                    ->firstOrFail();

                /*
                 * Update transaksi lama
                 */
                $transaction->update([
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $tax,
                    'other_fee' => $otherFee,
                    'grand_total' => $grandTotal,
                    'paid_amount' => 0,
                    'change_amount' => 0,
                    'payment_method' => 'Tunai',
                    'status' => 'held',
                ]);

                /*
                 * Hapus detail lama
                 * sebelum memasukkan detail terbaru.
                 */
                $transaction->details()->delete();

            } else {

                /*
                 * Buat transaksi baru
                 */
                $transaction = Transaction::create([
                    'transaction_number' =>
                        $this->generateTransactionNumber(),

                    'user_id' => Auth::id(),

                    'subtotal' => $subtotal,

                    'discount' => $discount,

                    'tax' => $tax,

                    'other_fee' => $otherFee,

                    'grand_total' => $grandTotal,

                    'paid_amount' => 0,

                    'change_amount' => 0,

                    'payment_method' => 'Tunai',

                    'status' => 'held',
                ]);
            }

            /*
             * Simpan detail transaksi
             */
            foreach ($items as $item) {

                TransactionDetail::create([
                    'transaction_id' =>
                        $transaction->id,

                    'product_id' =>
                        $item['product']->id,

                    'product_name' =>
                        $item['product']->name,

                    'price' =>
                        $item['product']->price,

                    'qty' =>
                        $item['qty'],

                    'discount' => 0,

                    'subtotal' =>
                        $item['subtotal'],
                ]);
            }

            return $transaction;
        });

        /*
         * Berhasil
         */
        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil ditahan.',
            'transaction' => $transaction->load('details'),
        ]);

    } catch (\Throwable $e) {

        /*
         * Jika terjadi error
         */
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 422);
    }
}


    /*
    |--------------------------------------------------------------------------
    | AMBIL TRANSAKSI YANG DITAHAN
    |--------------------------------------------------------------------------
    */

    public function getHeldTransaction(Transaction $transaction)
    {
        if ($transaction->status !== 'held') {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi ini sudah tidak tersedia.'
            ], 404);
        }

        $transaction->load('details');

        return response()->json([
            'success' => true,
            'transaction' => $transaction,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | BAYAR TRANSAKSI
    |--------------------------------------------------------------------------
    */

    public function pay(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => ['nullable', 'integer', 'exists:transactions,id'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'integer', 'exists:products,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],

            'discount' => ['nullable', 'numeric', 'min:0'],
            'tax' => ['nullable', 'numeric', 'min:0'],
            'other_fee' => ['nullable', 'numeric', 'min:0'],

            'paid_amount' => ['required', 'numeric', 'min:0'],

            'payment_method' => [
                'required',
                'string',
                'max:50'
            ],
        ]);

        return DB::transaction(function () use ($validated) {

            $subtotal = 0;

            $items = [];

            /*
             * Ambil produk dengan lock supaya stok
             * tidak berubah saat proses pembayaran.
             */
            foreach ($validated['items'] as $item) {

                $product = Product::where('id', $item['id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $qty = (int) $item['qty'];

                if ($qty > $product->stock) {

                    return response()->json([
                        'success' => false,
                        'message' => "Stok {$product->name} hanya tersisa {$product->stock}."
                    ], 422);

                }

                $itemSubtotal = $product->price * $qty;

                $subtotal += $itemSubtotal;

                $items[] = [
                    'product' => $product,
                    'qty' => $qty,
                    'subtotal' => $itemSubtotal,
                ];
            }


            $discount = (float) ($validated['discount'] ?? 0);
            $tax = (float) ($validated['tax'] ?? 0);
            $otherFee = (float) ($validated['other_fee'] ?? 0);
            $paidAmount = (float) $validated['paid_amount'];


            $grandTotal = max(
                0,
                $subtotal - $discount + $tax + $otherFee
            );


            if ($paidAmount < $grandTotal) {

                return response()->json([
                    'success' => false,
                    'message' => 'Uang pembayaran masih kurang.'
                ], 422);

            }


            $changeAmount = $paidAmount - $grandTotal;


            /*
             * Kalau pembayaran berasal dari transaksi
             * yang sebelumnya ditahan, gunakan transaksi tersebut.
             */

            $transactionId = $validated['transaction_id'] ?? null;

            if ($transactionId) {

                $transaction = Transaction::where('id', $transactionId)
                    ->where('status', 'held')
                    ->lockForUpdate()
                    ->firstOrFail();

                $transaction->update([
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $tax,
                    'other_fee' => $otherFee,
                    'grand_total' => $grandTotal,
                    'paid_amount' => $paidAmount,
                    'change_amount' => $changeAmount,
                    'payment_method' => $validated['payment_method'],
                    'status' => 'completed',
                ]);

                $transaction->details()->delete();

            } else {

                $transaction = Transaction::create([
                    'transaction_number' => $this->generateTransactionNumber(),
                    'user_id' => Auth::id(),
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $tax,
                    'other_fee' => $otherFee,
                    'grand_total' => $grandTotal,
                    'paid_amount' => $paidAmount,
                    'change_amount' => $changeAmount,
                    'payment_method' => $validated['payment_method'],
                    'status' => 'completed',
                ]);

            }


            /*
             * Simpan detail transaksi
             */

            foreach ($items as $item) {

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'price' => $item['product']->price,
                    'qty' => $item['qty'],
                    'discount' => 0,
                    'subtotal' => $item['subtotal'],
                ]);


                /*
                 * BARU DI SINI STOK DIKURANGI
                 */

                $item['product']->decrement(
                    'stock',
                    $item['qty']
                );
            }


            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil.',
                'transaction' => $transaction,
                'change' => $changeAmount,
            ]);
        });
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS TRANSAKSI DITAHAN
    |--------------------------------------------------------------------------
    */

    public function deleteHeldTransaction(Transaction $transaction)
    {
        if ($transaction->status !== 'held') {

            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak dapat dihapus.'
            ], 422);

        }

        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi ditahan berhasil dihapus.'
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | NOMOR TRANSAKSI
    |--------------------------------------------------------------------------
    */

    private function generateTransactionNumber()
    {
        do {

            $number = 'TRX-' .
                date('Ymd') .
                '-' .
                strtoupper(substr(uniqid(), -6));

        } while (
            Transaction::where(
                'transaction_number',
                $number
            )->exists()
        );

        return $number;
    }
}
