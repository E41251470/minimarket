<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar transaksi.
     */
    public function index(Request $request)
    {
        $query = Transaction::query()->latest();

        // Pencarian berdasarkan ID transaksi.
        if ($request->filled('search')) {
            $search = $request->search;

            if (ctype_digit((string) $search)) {
                $query->where('id', (int) $search);
            }
        }

        $transactions = $query->paginate(10)->withQueryString();

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Mengunduh invoice transaksi dalam format PDF.
     */
    public function invoice($id)
    {
        // Cari transaksi.
        $transaction = Transaction::findOrFail($id);

        // Ambil detail barang dalam transaksi.
        $details = collect();

        if (Schema::hasTable('transaction_details')) {
            $details = DB::table('transaction_details')
                ->where('transaction_id', $transaction->id)
                ->get();
        }

        // Ambil nama produk berdasarkan product_id.
        if (
            Schema::hasTable('products') &&
            Schema::hasTable('transaction_details') &&
            Schema::hasColumn('transaction_details', 'product_id')
        ) {
            $productIds = $details->pluck('product_id')
                ->filter()
                ->unique();

            $products = DB::table('products')
                ->whereIn('id', $productIds)
                ->pluck('name', 'id');

            $details = $details->map(function ($detail) use ($products) {
                $detail->product_name = $products[$detail->product_id]
                    ?? 'Produk tidak ditemukan';

                return $detail;
            });
        } else {
            $details = $details->map(function ($detail) {
                $detail->product_name = 'Produk';

                return $detail;
            });
        }

        // Siapkan data invoice.
        $transactionNumber = 'TRX-' . str_pad(
            $transaction->id,
            5,
            '0',
            STR_PAD_LEFT
        );

        $total = $transaction->total
            ?? $transaction->grand_total
            ?? 0;

        $paymentMethod = $transaction->payment_method ?? '-';

        $date = $transaction->created_at
            ? $transaction->created_at->format('d-m-Y H:i')
            : '-';

        // Buat isi PDF.
        $html = '
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <style>
                body {
                    font-family: DejaVu Sans, sans-serif;
                    font-size: 12px;
                    color: #333;
                }

                .header {
                    text-align: center;
                    margin-bottom: 25px;
                }

                .header h2 {
                    margin-bottom: 5px;
                    color: #1E7AAF;
                }

                .info {
                    margin-bottom: 20px;
                    line-height: 1.8;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                }

                th {
                    background-color: #D3EBFA;
                    text-align: left;
                }

                .right {
                    text-align: right;
                }

                .total {
                    margin-top: 20px;
                    text-align: right;
                    font-size: 16px;
                    font-weight: bold;
                }

                .footer {
                    text-align: center;
                    margin-top: 40px;
                    color: #666;
                }
            </style>
        </head>
        <body>

            <div class="header">
                <h2>MINIMARKET</h2>
                <p>Invoice Pembelian</p>
            </div>

            <div class="info">
                <strong>Nomor Transaksi:</strong> '
                    . e($transactionNumber) . '<br>

                <strong>Tanggal:</strong> '
                    . e($date) . '<br>

                <strong>Metode Pembayaran:</strong> '
                    . e($paymentMethod) . '
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>';

        if ($details->isEmpty()) {
            $html .= '
                    <tr>
                        <td colspan="5" style="text-align:center">
                            Detail produk tidak tersedia.
                        </td>
                    </tr>';
        } else {
            foreach ($details as $index => $detail) {
                $name = $detail->product_name ?? 'Produk';

                $quantity = $detail->quantity
                    ?? $detail->qty
                    ?? 0;

                $price = $detail->price
                    ?? $detail->unit_price
                    ?? 0;

                $subtotal = $detail->subtotal
                    ?? ($quantity * $price);

                $html .= '
                    <tr>
                        <td>' . ($index + 1) . '</td>
                        <td>' . e($name) . '</td>
                        <td>' . e($quantity) . '</td>
                        <td class="right">Rp'
                            . number_format((float) $price, 0, ',', '.') .
                        '</td>
                        <td class="right">Rp'
                            . number_format((float) $subtotal, 0, ',', '.') .
                        '</td>
                    </tr>';
            }
        }

        $html .= '
                </tbody>
            </table>

            <div class="total">
                Total Pembayaran: Rp'
                    . number_format((float) $total, 0, ',', '.') . '
            </div>

            <div class="footer">
                Terima kasih telah berbelanja di minimarket kami.
            </div>

        </body>
        </html>';

        // Hasilkan file PDF.
        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait');

        return $pdf->download('invoice-' . $transactionNumber . '.pdf');
    }
}
