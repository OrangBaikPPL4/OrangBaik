<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Donasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Donasi</h1>
        <p>Tanggal: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Metode Pembayaran</th>
                <th>Donatur</th>
                <th>Bencana</th>
                <th>Komentar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donations as $donation)
            <tr>
                <td>{{ $donation->transaction_id }}</td>
                <td>{{ $donation->created_at->format('d/m/Y H:i') }}</td>
                <td>Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                <td>
                    @if($donation->status === 'pending')
                        Menunggu
                    @elseif($donation->status === 'confirmed')
                        Dikonfirmasi
                    @elseif($donation->status === 'failed')
                        Gagal
                    @else
                        Disalurkan
                    @endif
                </td>
                <td>{{ $donation->payment_method === 'bank_transfer' ? 'Transfer Bank' : 'E-Wallet' }}</td>
                <td>{{ $donation->user ? $donation->user->name : 'Anonim' }}</td>
                <td>{{ $donation->disasterReport ? $donation->disasterReport->jenis_bencana . ' - ' . $donation->disasterReport->lokasi : '-' }}</td>
                <td>{{ $donation->statusHistories->last() ? $donation->statusHistories->last()->comment : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dihasilkan secara otomatis oleh sistem OrangBaik</p>
        <p>© {{ date('Y') }} OrangBaik. All rights reserved.</p>
    </div>
</body>
</html> 