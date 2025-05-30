<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Acara Volunteer') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('volunteer.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="nama_acara" class="block text-sm font-medium text-gray-700 mb-1">Nama Acara</label>
                                <input type="text" name="nama_acara" id="nama_acara" value="{{ old('nama_acara') }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>

                            <div>
                                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>

                            <div>
                                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>

                            <div>
                                <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>

                            <div class="md:col-span-2">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="5" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('deskripsi') }}</textarea>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="dalam proses" {{ old('status') == 'dalam proses' ? 'selected' : '' }}>Dalam Proses</option>
                                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="kuota_relawan" class="block text-sm font-medium text-gray-700 mb-1">Kuota Relawan</label>
                                <input type="number" name="kuota_relawan" id="kuota_relawan" value="{{ old('kuota_relawan') }}" min="1" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <p class="text-xs text-gray-500 mt-1">Jumlah maksimal relawan yang dapat bergabung</p>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Acara</label>
                                <input type="file" name="image" id="image" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2" accept="image/*">
                                <p class="text-xs text-gray-500 mt-1">Upload gambar untuk acara volunteer (format: JPG, PNG, maksimal 2MB)</p>
                            </div>
                        </div>

                        {{-- Bagian untuk Roles --}}
                        <div class="mt-6 mb-6 border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Peran/Tugas Volunteer (Opsional)</h3>
                            <div id="roles-container" class="space-y-4">
                                {{-- Roles akan ditambahkan di sini oleh JavaScript --}}
                            </div>
                            <button type="button" id="add-role-button" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Tambah Peran</button>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Tambah Acara
                            </button>
                            <a href="{{ route('volunteer.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rolesContainer = document.getElementById('roles-container');
    const addRoleButton = document.getElementById('add-role-button');
    let roleIndex = 0;

    addRoleButton.addEventListener('click', function () {
        const newRoleHtml = `
            <div class="p-4 border rounded-md role-item bg-gray-50">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="font-semibold text-gray-700">Peran ${roleIndex + 1}</h4>
                    <button type="button" class="text-sm text-red-600 hover:text-red-800 remove-role-button">Hapus Peran Ini</button>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="roles_${roleIndex}_name" class="block text-sm font-medium text-gray-700">Nama Peran*</label>
                        <input type="text" name="roles[${roleIndex}][name]" id="roles_${roleIndex}_name" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="roles_${roleIndex}_slots_needed" class="block text-sm font-medium text-gray-700">Jumlah Slot Dibutuhkan*</label>
                        <input type="number" name="roles[${roleIndex}][slots_needed]" id="roles_${roleIndex}_slots_needed" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="1" required>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="roles_${roleIndex}_description" class="block text-sm font-medium text-gray-700">Deskripsi Peran</label>
                    <textarea name="roles[${roleIndex}][description]" id="roles_${roleIndex}_description" rows="2" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>
                <div class="mt-4">
                    <label for="roles_${roleIndex}_estimated_work_hours" class="block text-sm font-medium text-gray-700">Estimasi Jam Kerja</label>
                    <input type="number" name="roles[${roleIndex}][estimated_work_hours]" id="roles_${roleIndex}_estimated_work_hours" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="0">
                </div>
            </div>
        `;
        rolesContainer.insertAdjacentHTML('beforeend', newRoleHtml);
        roleIndex++;
        updateRemoveRoleButtons();
    });

    function updateRemoveRoleButtons() {
        document.querySelectorAll('.remove-role-button').forEach(button => {
            button.removeEventListener('click', handleRemoveRole);
            button.addEventListener('click', handleRemoveRole);
        });
    }

    function handleRemoveRole(event) {
        event.target.closest('.role-item').remove();
        // Re-index or re-label if necessary, though backend handles non-sequential keys.
        // For now, just removing is fine.
        // Update h4 titles if needed
        const allRoleItems = rolesContainer.querySelectorAll('.role-item');
        allRoleItems.forEach((item, idx) => {
            const titleElement = item.querySelector('h4');
            if (titleElement) {
                titleElement.textContent = `Peran ${idx + 1}`;
            }
        });
        // If all roles are removed, roleIndex might need to be reset if you want to start from 0 again
        // but for submission, it's fine. If you add a new role after deleting all, it will continue from the last roleIndex.
        // If you want to reset roleIndex when rolesContainer is empty:
        if (allRoleItems.length === 0) {
             roleIndex = 0;
        }
    }
    
    updateRemoveRoleButtons(); // Initial call for any pre-existing roles (not applicable for create, but good for edit)
});
</script>
@endpush
</x-app-layout>
