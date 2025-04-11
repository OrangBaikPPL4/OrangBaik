<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan Bencana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">📋 Daftar Laporan Bencana</h2>
        <a href="{{ route('disaster_report.create') }}" class="btn btn-primary">
            + Buat Laporan Baru
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            @if($disasterReports->isEmpty())
                <div class="alert alert-info text-center">Belum ada laporan bencana.</div>
            @else
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
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
                                <td>{{ \Illuminate\Support\Str::limit($report->deskripsi, 50) }}</td>
                                <td>
                                    <span class="badge bg-{{ $report->status === 'pending' ? 'warning' : ($report->status === 'diterima' ? 'success' : 'secondary') }}">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('disaster_report.show', $report->id) }}" class="btn btn-sm btn-outline-info">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

</body>
</html>
