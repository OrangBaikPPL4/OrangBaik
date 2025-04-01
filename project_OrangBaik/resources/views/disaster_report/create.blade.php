<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bencana</title>
</head>
<body>
    <h1>Form Laporan Bencana</h1>

    <!-- Menampilkan pesan sukses jika ada -->
    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('disaster_report.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Lokasi Bencana -->
        <label for="lokasi">Lokasi:</label>
        <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required>
        @error('lokasi')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <br><br>

        <!-- Jenis Bencana -->
        <label for="jenis_bencana">Jenis Bencana:</label>
        <select name="jenis_bencana" id="jenis_bencana" required>
            <option value="banjir" {{ old('jenis_bencana') == 'banjir' ? 'selected' : '' }}>Banjir</option>
            <option value="gempa" {{ old('jenis_bencana') == 'gempa' ? 'selected' : '' }}>Gempa</option>
            <option value="kebakaran" {{ old('jenis_bencana') == 'kebakaran' ? 'selected' : '' }}>Kebakaran</option>
            <option value="longsor" {{ old('jenis_bencana') == 'longsor' ? 'selected' : '' }}>Longsor</option>
            <option value="lainnya" {{ old('jenis_bencana') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>
        @error('jenis_bencana')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <br><br>

        <!-- Deskripsi Bencana -->
        <label for="deskripsi">Deskripsi:</label>
        <textarea name="deskripsi" id="deskripsi" required>{{ old('deskripsi') }}</textarea>
        @error('deskripsi')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <br><br>

        <!-- Upload Bukti Media -->
        <label for="bukti_media">Bukti Media (Foto/Video):</label>
        <input type="file" name="bukti_media[]" id="bukti_media" multiple>
        @error('bukti_media')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <br><br>

        <!-- Submit Button -->
        <button type="submit">Kirim Laporan</button>
    </form>
</body>
</html>
