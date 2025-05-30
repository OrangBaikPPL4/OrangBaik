<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Buat Testimoni
            </h2>
        </div>
    </x-slot>

    @section('content')
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-200 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6 border space-y-4">
                <form method="POST" action="{{ route('testimoni.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi Bencana</label>
                        <input type="text" name="lokasi" id="lokasi"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm" required>
                    </div>

                    <div>
                        <label for="jenis_bencana" class="block text-sm font-medium text-gray-700">Jenis Bencana</label>
                        <select name="jenis_bencana" id="jenis_bencana" onchange="toggleLainnyaField(this)"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm" required>
                            <option value="">-- Pilih --</option>
                            <option value="banjir">Banjir</option>
                            <option value="gempa">Gempa</option>
                            <option value="kebakaran">Kebakaran</option>
                            <option value="longsor">Longsor</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div id="jenis_bencana_lain_field" class="hidden">
                        <label for="jenis_bencana_lain" class="block text-sm font-medium text-gray-700">Jenis Bencana (Lainnya)</label>
                        <input type="text" name="jenis_bencana_lain" id="jenis_bencana_lain"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                    </div>

                    <div>
                        <label for="isicerita" class="block text-sm font-medium text-gray-700">Cerita Pengalaman</label>
                        <textarea name="isicerita" id="isicerita" rows="5"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm"
                            required></textarea>
                    </div>

                    <div>
                        <label for="foto" class="block text-sm font-medium text-gray-700">Foto (opsional)</label>
                        <input type="file" name="foto" id="foto"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('testimoni.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Kembali
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Kirim Testimoni
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleLainnyaField(select) {
            const lainnyaField = document.getElementById('jenis_bencana_lain_field');
            lainnyaField.classList.toggle('hidden', select.value !== 'lainnya');
        }
    </script>
    @endsection
</x-app-layout>
