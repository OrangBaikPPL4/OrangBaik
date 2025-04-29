@php
    use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan Bencana</title>

    <!-- Link Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-3xl bg-white rounded-xl shadow-lg p-8 m-4">
        <h1 class="text-3xl font-bold text-center text-blue-700 mb-10">Detail Laporan Bencana</h1>

        <div class="space-y-6">
            <!-- Lokasi -->
            <div>
                <label class="block text-sm font-bold text-gray-600 mb-1">Lokasi:</label>
                <div class="p-3 bg-gray-100 rounded-md">{{ $report->lokasi }}</div>
            </div>

            <!-- Jenis Bencana -->
            <div>
                <label class="block text-sm font-bold text-gray-600 mb-1">Jenis Bencana:</label>
                <div class="p-3 bg-gray-100 rounded-md">{{ ucfirst($report->jenis_bencana) }}</div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-bold text-gray-600 mb-1">Deskripsi:</label>
                <div class="p-3 bg-gray-100 rounded-md">{{ $report->deskripsi }}</div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-bold text-gray-600 mb-1">Status:</label>
                <div class="p-3 bg-gray-100 rounded-md">{{ ucfirst($report->status) }}</div>
            </div>

            <!-- Bukti Media -->
            <div>
                <label class="block text-sm font-bold text-gray-600 mb-1">Bukti Media:</label>
                <div class="bg-gray-100 p-3 rounded-md flex flex-col items-center">
                    @if($report->bukti_media)
                        @foreach(json_decode($report->bukti_media, true) as $media)
                            @if(Str::endsWith($media, ['.jpg', '.jpeg', '.png', '.gif']))
                                <img src="{{ asset('storage/bukti_bencana/' . basename($media)) }}" alt="Bukti Gambar" class="rounded-md shadow-md max-w-full my-4">
                            @elseif(Str::endsWith($media, ['.mp4', '.webm']))
                                <video controls class="rounded-md shadow-md max-w-full my-4">
                                    <source src="{{ asset('storage/bukti_bencana/' . basename($media)) }}" type="video/mp4">
                                    Browser tidak mendukung tag video.
                                </video>
                            @endif
                        @endforeach
                    @else
                        <p class="italic text-gray-500">Tidak ada media yang dilampirkan.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex justify-center mt-8">
            <a href="{{ route('disaster_report.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                Kembali ke Daftar
            </a>
        </div>
    </div>

</body>
</html>
