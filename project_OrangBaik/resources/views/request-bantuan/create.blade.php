<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Request Bantuan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 80px auto;
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #444;
        }

        select, textarea, input[type="text"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        select:focus, textarea:focus, input:focus {
            border-color: #4a90e2;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4a90e2;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #357ab7;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Request Bantuan</h1>

        <!-- Jika ingin munculkan pesan sukses dari backend -->
        {{-- @if(session('success')) --}}
        <!-- <div class="success">{{ session('success') }}</div> -->
        {{-- @endif --}}

        <form method="POST" action="{{ route('request-bantuan.store') }}">
            @csrf

            <label for="kategori">Kategori Bantuan</label>
            <select name="jenis_kebutuhan" id="jenis_kebutuhan" required>
                <option value="" disabled selected>Pilih Kategori</option>
                <option value="makanan">Makanan</option>
                <option value="obat">Obat</option>
                <option value="pakaian">Pakaian</option>
            </select>

            <label for="deskripsi">Deskripsi Kebutuhan</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" required placeholder="Contoh: Membutuhkan obat flu dan makanan bayi..."></textarea>

            <button type="submit">Ajukan Permintaan</button>
        </form>
    </div>

</body>
</html>
