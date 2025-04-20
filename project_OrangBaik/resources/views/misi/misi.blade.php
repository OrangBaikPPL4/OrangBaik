<h2>Daftar Misi Bantuan</h2>

@foreach($misis as $misi)
    <div style="border:1px solid #ccc; padding:10px; margin:10px;">
        <h3>{{ $misi->nama_misi }}</h3>
        <p>Status: {{ $misi->status }}</p>
        <p>{{ $misi->deskripsi }}</p>

        <form method="POST" action="{{ route('misi.gabung', $misi->id) }}">
            @csrf
            <input type="hidden" name="relawan_id" value="1"> {{-- Sesuaikan dengan relawan login --}}
            <button type="submit">Gabung Misi</button>
        </form>

        <form method="POST" action="{{ route('misi.lapor', $misi->id) }}">
            @csrf
            <input type="hidden" name="relawan_id" value="1">
            <textarea name="laporan" placeholder="Laporan progress..."></textarea><br>
            <button type="submit">Kirim Laporan</button>
        </form>
    </div>
@endforeach
