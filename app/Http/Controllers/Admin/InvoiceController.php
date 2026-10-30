<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download($id)
    {
        $transaction = DB::table('transactions')
            ->where('id', $id)
            ->first();

        abort_if(!$transaction, 404, 'Transaksi tidak ditemukan.');

        $details = DB::table('transaction_details')
            ->where('transaction_id', $id)
            ->get();

        $pdf = Pdf::loadView('invoices.invoice', [
            'transaction' => $transaction,
            'details' => $details,
        ]);

        return $pdf->download(
            'invoice-' . $transaction->transaction_number . '.pdf'
        );
    }
}
