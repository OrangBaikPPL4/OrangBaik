<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Relawan</title>
</head>
<body>
    <h1>Data Relawan</h1>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($relawans as $relawan)
            <tr>
                <td>{{ $relawan->nama }}</td>
                <td>{{ $relawan->email }}</td>
                <td>{{ $relawan->no_telepon }}</td>
                <td>
                    <a href="#">Edit</a> |
                    <a href="#">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
