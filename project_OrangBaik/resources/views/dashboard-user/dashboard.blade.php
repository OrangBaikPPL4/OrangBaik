<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2>Dashboard User</h2>

        <div class="alert alert-success">
            Selamat datang, {{ Auth::user()->name }}!
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Aksi Cepat</h5>
                <a href="{{ route('request-bantuan.create') }}" class="btn btn-primary">Ajukan Permintaan Bantuan</a>
                <a href="{{ route('request-bantuan.index') }}" class="btn btn-secondary">Riwayat Permintaan Saya</a>
            </div>
        </div>

        <h4>Riwayat Permintaan Bantuan</h4>

        @if ($requests->isEmpty())
            <div class="alert alert-info">Anda belum mengajukan permintaan bantuan.</div>
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
                    @foreach ($requests as $i => $req)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ ucfirst($req->jenis_kebutuhan) }}</td>
                            <td>{{ $req->deskripsi ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ match($req->status) {
                                    'pending' => 'secondary',
                                    'diproses' => 'warning',
                                    'selesai' => 'success',
                                    'ditolak' => 'danger',
                                    default => 'dark'
                                } }}">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td>{{ $req->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
</body>
</html>
