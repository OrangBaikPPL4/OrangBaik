<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kirim Testimoni</h2>
    

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('testimoni.store') }}" enctype="multipart/form-data" class="bg-white p-6 shadow rounded space-y-4">
                @csrf

                <div>
                    <label for="lokasi" class="block font-medium text-sm text-gray-700">Lokasi Bencana</label>
                    <input type="text" name="lokasi" id="lokasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label for="jenis_bencana" class="block font-medium text-sm text-gray-700">Jenis Bencana</label>
                    <select name="jenis_bencana" id="jenis_bencana" onchange="toggleLainnyaField(this)" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">-- Pilih --</option>
                        <option value="banjir">Banjir</option>
                        <option value="gempa">Gempa</option>
                        <option value="kebakaran">Kebakaran</option>
                        <option value="longsor">Longsor</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div id="jenis_bencana_lain_field" class="hidden">
                    <label for="jenis_bencana_lain" class="block font-medium text-sm text-gray-700">Jenis Bencana (Lainnya)</label>
                    <input type="text" name="jenis_bencana_lain" id="jenis_bencana_lain" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div>
                    <label for="isicerita" class="block font-medium text-sm text-gray-700">Cerita Pengalaman</label>
                    <textarea name="isicerita" id="isicerita" rows="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                </div>

                <div>
                    <label for="foto" class="block font-medium text-sm text-gray-700">Foto (opsional)</label>
                    <input type="file" name="foto" id="foto" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Kirim Testimoni
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleLainnyaField(select) {
            const lainnyaField = document.getElementById('jenis_bencana_lain_field');
            lainnyaField.classList.toggle('hidden', select.value !== 'lainnya');
        }
    </script>

    </x-slot>
</x-app-layout>
