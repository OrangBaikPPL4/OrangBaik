<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Relawan</title>
</head>
<body>
    <h1>Tambah Relawan</h1>
    <form action="{{ route('relawan.store') }}" method="POST">
        @csrf
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email"><br><br>

        <label for="no_telepon">No. Telepon:</label>
        <input type="text" name="no_telepon" id="no_telepon"><br><br>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>
