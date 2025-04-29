<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laporan Bencana</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-2xl bg-white rounded-xl shadow-md p-8">
        <h1 class="text-2xl font-bold text-center text-blue-700 mb-6">Edit Laporan Bencana</h1>

        <form action="{{ route('disaster_report.update', $report->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Lokasi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $report->lokasi) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('lokasi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Bencana -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Bencana</label>
                <select name="jenis_bencana" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach(['banjir', 'gempa', 'kebakaran', 'longsor', 'lainnya'] as $jenis)
                        <option value="{{ $jenis }}" @selected($report->jenis_bencana === $jenis)>
                            {{ ucfirst($jenis) }}
                        </option>
                    @endforeach
                </select>
                @error('jenis_bencana')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi', $report->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Bukti Media -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Media (gambar atau video)</label>
                <input type="file" name="bukti_media[]" multiple accept="image/*,video/*" class="w-full">
                @error('bukti_media.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                @if ($report->bukti_media)
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        @foreach(json_decode($report->bukti_media, true) as $media)
                            @if(Str::endsWith($media, ['.jpg', '.jpeg', '.png', '.gif']))
                                <img src="{{ asset('storage/bukti_bencana/' . $media) }}" class="w-full rounded-md shadow-md">
                            @elseif(Str::endsWith($media, ['.mp4', '.webm']))
                                <video controls class="w-full rounded-md shadow-md">
                                    <source src="{{ asset('storage/bukti_bencana/' . $media) }}" type="video/mp4">
                                </video>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Tombol Simpan -->
            <div class="text-center mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('disaster_report.index') }}" class="ml-3 text-gray-600 hover:text-blue-600 text-sm">Batal</a>
            </div>
        </form>
    </div>

</body>
</html>
