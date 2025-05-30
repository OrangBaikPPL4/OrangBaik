<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifikasi Acara Volunteer') }}
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

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Notifikasi Acara Volunteer</h3>
                        
                        @if($notifications->where('is_read', false)->count() > 0)
                            <form action="{{ route('volunteer.notifications.mark-all-read') }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Tandai Semua Dibaca
                                </button>
                            </form>
                        @endif
                    </div>

                    @if($notifications->count() > 0)
                        <div class="space-y-4">
                            @foreach($notifications as $notification)
                                <div class="border rounded-lg overflow-hidden {{ $notification->is_read ? 'bg-white' : 'bg-blue-50' }} {{ 
                                    $notification->type == 'info' ? 'border-blue-200' : 
                                    ($notification->type == 'warning' ? 'border-yellow-200' : 
                                    ($notification->type == 'success' ? 'border-green-200' : 'border-red-200')) 
                                }}">
                                    <div class="p-4">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h4 class="text-lg font-semibold {{ $notification->is_read ? 'text-gray-700' : 'text-gray-900' }}">
                                                    {{ $notification->title }}
                                                </h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ $notification->created_at->format('d M Y, H:i') }}
                                                    @if($notification->volunteer)
                                                        - <a href="{{ route('volunteer.show', $notification->volunteer_id) }}" class="text-blue-500 hover:underline">{{ $notification->volunteer->nama_acara }}</a>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="flex space-x-2">
                                                @if(!$notification->is_read)
                                                    <form action="{{ route('volunteer.notifications.mark-read', $notification->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="text-sm text-blue-500 hover:text-blue-700">
                                                            Tandai Dibaca
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('volunteer.notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus notifikasi ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm text-red-500 hover:text-red-700">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="mt-2 whitespace-pre-line">
                                            {{ $notification->message }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada notifikasi</h3>
                            <p class="mt-1 text-sm text-gray-500">Anda akan menerima notifikasi saat ada perubahan pada acara volunteer yang Anda ikuti.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
