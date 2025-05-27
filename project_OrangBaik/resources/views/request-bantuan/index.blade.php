<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Permintaan Bantuan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <div class="container py-5">
        <h2 class="mb-4">Riwayat Permintaan Bantuan Saya</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($requests->isEmpty())
            <div class="alert alert-info">
                Belum ada permintaan bantuan yang diajukan.
            </div>
        @else
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Jenis Kebutuhan</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $index => $req)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ ucfirst($req->jenis_kebutuhan) }}</td>
                            <td>{{ $req->deskripsi ?? '-' }}</td>
                            <td>
                                @php
                                    $badge = match($req->status) {
                                        'pending' => 'secondary',
                                        'diproses' => 'warning',
                                        'selesai' => 'success',
                                        'ditolak' => 'danger',
                                        default => 'dark'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ ucfirst($req->status) }}</span>
                            </td>
                            <td>
                                @if($req->status == 'diproses' || $req->status == 'selesai')
                                    {{ $req->updated_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                                @else
                                    {{ $req->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('request-bantuan.create') }}" class="btn btn-primary mt-3">Ajukan Permintaan Baru</a>
    </div>

</body>
</html>
