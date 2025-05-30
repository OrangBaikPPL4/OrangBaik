<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Acara Volunteer') }}
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

                    <form method="POST" action="{{ route('volunteer.update', $volunteer->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="nama_acara" class="block text-sm font-medium text-gray-700 mb-1">Nama Acara</label>
                                <input type="text" name="nama_acara" id="nama_acara" value="{{ old('nama_acara', $volunteer->nama_acara) }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>

                            <div>
                                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $volunteer->lokasi) }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>

                            <div>
                                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai', $volunteer->tanggal_mulai) }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>

                            <div>
                                <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai', $volunteer->tanggal_selesai) }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>

                            <div class="md:col-span-2">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="5" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('deskripsi', $volunteer->deskripsi) }}</textarea>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="aktif" {{ old('status', $volunteer->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="dalam_proses" {{ old('status', $volunteer->status) == 'dalam_proses' || old('status', $volunteer->status) == 'dalam proses' ? 'selected' : '' }}>Dalam Proses</option>
                                    <option value="selesai" {{ old('status', $volunteer->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditunda" {{ old('status', $volunteer->status) == 'ditunda' ? 'selected' : '' }}>Ditunda</option>
                                    <option value="dibatalkan" {{ old('status', $volunteer->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="kuota_relawan" class="block text-sm font-medium text-gray-700 mb-1">Kuota Relawan</label>
                                <input type="number" name="kuota_relawan" id="kuota_relawan" value="{{ old('kuota_relawan', $volunteer->kuota_relawan) }}" min="1" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <p class="text-xs text-gray-500 mt-1">Jumlah maksimal relawan yang dapat bergabung</p>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Acara</label>
                                @if($volunteer->image_url)
                                    <div class="mb-2">
                                        <img src="{{ $volunteer->image_url }}" alt="{{ $volunteer->nama_acara }}" class="h-32 w-auto rounded">
                                        <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2" accept="image/*">
                                <p class="text-xs text-gray-500 mt-1">Upload gambar baru untuk acara volunteer (format: JPG, PNG, maksimal 2MB)</p>
                            </div>
                        </div>

                        {{-- Bagian untuk Roles --}}
                        <div class="mt-6 mb-6 border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Peran/Tugas Volunteer</h3>
                            <div id="roles-container" class="space-y-4">
                                {{-- Roles yang sudah ada --}}
                                @if(old('roles') || (isset($event) && $event->roles))
                                    @php 
                                        $roles_data = old('roles', $event->roles->map(function($role) {
                                            return [
                                                'name' => $role->name,
                                                'slots_needed' => $role->slots_needed,
                                                'description' => $role->description,
                                                'estimated_work_hours' => $role->estimated_work_hours
                                            ];
                                        })->toArray());
                                    @endphp
                                    @foreach($roles_data as $index => $role)
                                    <div class="p-4 border rounded-md role-item bg-gray-50">
                                        <div class="flex justify-between items-center mb-2">
                                            <h4 class="font-semibold text-gray-700">Peran {{ $loop->iteration }}</h4>
                                            <button type="button" class="text-sm text-red-600 hover:text-red-800 remove-role-button">Hapus Peran Ini</button>
                                        </div>
                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <div>
                                                <label for="roles_{{ $index }}_name" class="block text-sm font-medium text-gray-700">Nama Peran*</label>
                                                <input type="text" name="roles[{{ $index }}][name]" id="roles_{{ $index }}_name" value="{{ $role['name'] ?? '' }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                            </div>
                                            <div>
                                                <label for="roles_{{ $index }}_slots_needed" class="block text-sm font-medium text-gray-700">Jumlah Slot Dibutuhkan*</label>
                                                <input type="number" name="roles[{{ $index }}][slots_needed]" id="roles_{{ $index }}_slots_needed" value="{{ $role['slots_needed'] ?? '' }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="1" required>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <label for="roles_{{ $index }}_description" class="block text-sm font-medium text-gray-700">Deskripsi Peran</label>
                                            <textarea name="roles[{{ $index }}][description]" id="roles_{{ $index }}_description" rows="2" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $role['description'] ?? '' }}</textarea>
                                        </div>
                                        <div class="mt-4">
                                            <label for="roles_{{ $index }}_estimated_work_hours" class="block text-sm font-medium text-gray-700">Estimasi Jam Kerja</label>
                                            <input type="number" name="roles[{{ $index }}][estimated_work_hours]" id="roles_{{ $index }}_estimated_work_hours" value="{{ $role['estimated_work_hours'] ?? '' }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="0">
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" id="add-role-button" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Tambah Peran Baru</button>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan Perubahan
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
    let roleIndex = {{ (old('roles') ? count(old('roles')) : (isset($event) && $event->roles ? $event->roles->count() : 0)) }};

    addRoleButton.addEventListener('click', function () {
        // Determine the next index. If roles were deleted, new roles should not reuse old indices to avoid conflicts on the backend
        // A simple way is to use a potentially large number or a timestamp-based index if we don't re-index on delete.
        // For simplicity here, we'll just increment from the current highest known index or a new counter if all are deleted.
        // A better approach for dynamic forms is to ensure unique indices, e.g., by using a counter that only ever increments.
        // Let's find the maximum existing index from input names to ensure new roles don't clash.
        let maxIndex = -1;
        document.querySelectorAll('#roles-container .role-item input[name^="roles["]').forEach(input => {
            const match = input.name.match(/roles\[(\d+)\]/);
            if (match && parseInt(match[1]) > maxIndex) {
                maxIndex = parseInt(match[1]);
            }
        });
        roleIndex = maxIndex + 1;

        const newRoleHtml = `
            <div class="p-4 border rounded-md role-item bg-gray-50">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="font-semibold text-gray-700">Peran Baru</h4>
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
        // roleIndex++; // Index is now managed by finding max existing index
        updateRoleItemTitles();
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
        updateRoleItemTitles();
    }

    function updateRoleItemTitles(){
        const allRoleItems = rolesContainer.querySelectorAll('.role-item');
        allRoleItems.forEach((item, idx) => {
            const titleElement = item.querySelector('h4');
            if (titleElement) {
                // Check if it's a 'Peran Baru' or an existing one
                if (!titleElement.textContent.startsWith('Peran Baru')) {
                     titleElement.textContent = `Peran ${idx + 1}`;
                } else if (allRoleItems.length > 0 && titleElement.textContent.startsWith('Peran Baru') && allRoleItems.length === (idx +1) ) {
                    // If it is the last 'Peran Baru' item, update its title based on its new position
                    // This is a bit simplistic, might need refinement if multiple 'Peran Baru' items can exist before save
                }
            }
        });
        // If all roles are removed, roleIndex might need to be reset if you want to start from 0 again
        // but for submission, it's fine. If you add a new role after deleting all, it will continue from the last roleIndex.
        if (allRoleItems.length === 0) {
             // roleIndex = 0; // Resetting index might be complex if server expects specific keys for update/delete
        }
    }
    
    updateRemoveRoleButtons(); // Initial call for existing roles
    updateRoleItemTitles(); // Initial call to set titles for existing roles
});
</script>
@endpush
</x-app-layout>
