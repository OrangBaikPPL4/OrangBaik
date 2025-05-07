<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="relative">
        <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>

    <div x-show="open" 
         @click.away="open = false"
         class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg overflow-hidden z-50">
        <div class="py-2">
            @forelse(auth()->user()->notifications()->take(5)->get() as $notification)
                <div class="px-4 py-3 hover:bg-gray-100 {{ $notification->read_at ? 'opacity-50' : '' }}">
                    @if($notification->type === 'App\Notifications\DonationStatusUpdated')
                        <p class="text-sm text-gray-800">
                            Status donasi Anda telah diperbarui menjadi 
                            <span class="font-medium">{{ $notification->data['status'] }}</span>
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            Donasi: Rp {{ number_format($notification->data['amount'], 2) }}
                        </p>
                        <div class="mt-2 flex justify-between items-center">
                            <a href="{{ url('/donations/' . $notification->data['donation_id']) }}" 
                               class="text-xs text-indigo-600 hover:text-indigo-900">
                                Lihat Detail
                            </a>
                            <span class="text-xs text-gray-500">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                    @endif
                </div>
            @empty
                <div class="px-4 py-3 text-sm text-gray-500">
                    Tidak ada notifikasi
                </div>
            @endforelse

            @if(auth()->user()->notifications->count() > 5)
                <div class="px-4 py-2 bg-gray-50 text-center">
                    <a href="{{ route('notifications.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                        Lihat Semua Notifikasi
                    </a>
                </div>
            @endif
        </div>
    </div>
</div> 