<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan Bencana</title>
</head>
<body>
    <h1>Daftar Laporan Bencana</h1>

    <!-- Tombol Tambah Laporan -->
    <a href="{{ route('disaster_report.create') }}">Buat Laporan Baru</a>

    <!-- Menampilkan daftar laporan -->
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Lokasi</th>
                <th>Jenis Bencana</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($disasterReports as $key => $report)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $report->lokasi }}</td>
                    <td>{{ $report->jenis_bencana }}</td>
                    <td>{{ $report->deskripsi }}</td>
                    <td>{{ ucfirst($report->status) }}</td>
                    <td>
                        <a href="{{ route('disaster_report.show', $report->id) }}">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
