
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Minimarket</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .total {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>MINIMARKET</h2>
    <p>Invoice: {{ $transaction->transaction_number }}</p>
    <p>
        Tanggal:
        {{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>
                        Rp{{ number_format($item->price, 0, ',', '.') }}
                    </td>
                    <td>{{ $item->qty }}</td>
                    <td>
                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>
            Total:
            <strong>
                Rp{{ number_format($transaction->grand_total, 0, ',', '.') }}
            </strong>
        </p>
        <p>
            Dibayar:
            Rp{{ number_format($transaction->paid_amount, 0, ',', '.') }}
        </p>
        <p>
            Kembalian:
            Rp{{ number_format($transaction->change_amount, 0, ',', '.') }}
        </p>
    </div>
</body>
</html>
