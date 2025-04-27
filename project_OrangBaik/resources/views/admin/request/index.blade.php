<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Permintaan Bantuan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2>Semua Permintaan Bantuan Korban</h2>

        {{-- Filter Jenis Kebutuhan --}}
        <form action="{{ route('admin.request-bantuan.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="jenis_kebutuhan" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Semua Jenis Bantuan --</option>
                        <option value="makanan" {{ request('jenis_kebutuhan') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="obat" {{ request('jenis_kebutuhan') == 'obat' ? 'selected' : '' }}>Obat</option>
                        <option value="pakaian" {{ request('jenis_kebutuhan') == 'pakaian' ? 'selected' : '' }}>Pakaian</option>
                    </select>
                </div>
                <div class="col-md-2">
                    @if(request('jenis_kebutuhan'))
                        <a href="{{ route('admin.request-bantuan.index') }}" class="btn btn-secondary">Reset Filter</a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Tabel Daftar Permintaan --}}
        @if ($requests->isEmpty())
            <div class="alert alert-info">Belum ada permintaan.</div>
        @else
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Korban</th>
                        <th>Jenis Kebutuhan</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Ubah Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $i => $req)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $req->user->name ?? 'Tidak diketahui' }}</td>
                            <td>{{ ucfirst($req->jenis_kebutuhan) }}</td>
                            <td>{{ $req->deskripsi ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ match($req->status) {
                                    'pending' => 'secondary',
                                    'diproses' => 'warning',
                                    'selesai' => 'success',
                                    'ditolak' => 'danger',
                                    default => 'dark'
                                } }}">{{ ucfirst($req->status) }}</span>
                            </td>
                            <td>{{ $req->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.request-bantuan.update-status', $req->id) }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <select name="status" class="form-select" onchange="this.form.submit()">
                                            <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="diproses" {{ $req->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="selesai" {{ $req->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="ditolak" {{ $req->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
