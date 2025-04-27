<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <h2 class="mb-4">Dashboard User</h2>

        <div class="alert alert-success">
            Selamat datang, {{ Auth::user()->name }}! 👋
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Aksi Cepat</h5>
                <p class="card-text">Silakan pilih aksi berikut:</p>
                <a href="{{ route('request-bantuan.create') }}" class="btn btn-primary">Ajukan Permintaan Bantuan</a>
                <a href="{{ route('request-bantuan.index') }}" class="btn btn-secondary">Riwayat Permintaan Saya</a>
            </div>
        </div>
    </div>

</body>
</html>
