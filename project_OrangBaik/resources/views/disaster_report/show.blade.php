@php
    use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan Bencana</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .label {
            font-weight: bold;
            margin-top: 15px;
            color: #555;
        }

        .value {
            margin-top: 5px;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 6px;
            color: #333;
        }

        .media-preview img, .media-preview video {
            max-width: 100%;
            margin-top: 10px;
            border-radius: 8px;
        }

        .back-link {
            display: inline-block;
            margin-top: 25px;
            text-decoration: none;
            color: white;
            background: #3490dc;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .back-link:hover {
            background: #2779bd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detail Laporan Bencana</h1>

        <div class="label">Lokasi:</div>
        <div class="value">{{ $report->lokasi }}</div>

        <div class="label">Jenis Bencana:</div>
        <div class="value">{{ ucfirst($report->jenis_bencana) }}</div>

        <div class="label">Deskripsi:</div>
        <div class="value">{{ $report->deskripsi }}</div>

        <div class="label">Status:</div>
        <div class="value">{{ ucfirst($report->status) }}</div>

        <div class="label">Bukti Media:</div>
        <div class="value media-preview">
            @if($report->bukti_media)
                @foreach(json_decode($report->bukti_media, true) as $media)
                    @if(Str::endsWith($media, ['.jpg', '.jpeg', '.png', '.gif']))
                        <img src="{{ asset('storage/' . $media) }}" alt="Bukti Gambar">
                    @elseif(Str::endsWith($media, ['.mp4', '.webm']))
                        <video controls>
                            <source src="{{ asset('storage/' . $media) }}" type="video/mp4">
                            Browser tidak mendukung tag video.
                        </video>
                    @endif
                @endforeach
            @else
                <p>Tidak ada media yang dilampirkan.</p>
            @endif
        </div>

        <a href="{{ route('disaster_report.index') }}" class="back-link">Kembali ke Daftar</a>
    </div>
</body>
</html>
