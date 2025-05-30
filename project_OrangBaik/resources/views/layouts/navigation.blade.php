<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Beranda') }}
                    </x-nav-link>
                    
                    <!-- Relawan Link -->
                    <x-nav-link :href="route('relawan.index')" :active="request()->routeIs('relawan.*')">
                        {{ __('Relawan') }}
                    </x-nav-link>
                    
                    <!-- Misi Link -->
                    <x-nav-link :href="route('misi.index')" :active="request()->routeIs('misi.*')">
                        {{ __('Misi Bantuan') }}
                    </x-nav-link>
                    
                    @if(Auth::user()->usertype === 'admin')
                    <!-- Volunteer Link -->
                    <x-nav-link :href="route('volunteer.index')" :active="request()->routeIs('volunteer.*')">
                        {{ __('Volunteer') }}
                    </x-nav-link>
                    @endif


                    <!-- Donations Link -->
                    <x-nav-link :href="route('donations.index')" :active="request()->routeIs('donations.*')">
                        {{ __('Donasi') }}
                    </x-nav-link>

                    <!-- Request Bantuan Link -->
                    <x-nav-link :href="route('admin.request-bantuan.index')" :active="request()->routeIs('admin.request-bantuan.*')">
                        {{ __('Request Bantuan') }}
                    </x-nav-link>

                    <!-- Edukasi Link -->
                    <x-nav-link :href="route('edukasi.menu')" :active="request()->routeIs('edukasi.*')">
                        {{ __('Edukasi') }}
                    </x-nav-link>

                     <!-- Disaster Report -->
                    <x-nav-link :href="route('admin.disaster_reports.index')" :active="request()->routeIs('admin.disaster_report.*')">
                        {{ __('Laporan Bencana') }}
                    </x-nav-link>

                    
                    @if(Auth::user()->usertype === 'admin')
                        <!-- Admin Dashboard -->
                        <x-nav-link :href="route('admin.faq.index')" :active="request()->routeIs('admin.faq.*')">
                            {{ __('Manajemen FAQ') }}
                        </x-nav-link>
                        
                        <!-- Announcements -->
                        <x-nav-link :href="route('admin.announcements.index')" :active="request()->routeIs('admin.announcements.*')">
                            {{ __('Pengumuman') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard.admin')" :active="request()->routeIs('dashboard.admin')">
                            {{ __('Admin') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if(Auth::user()->usertype === 'admin')
                <!-- Admin Notifications -->
                <div class="mr-4">
                    <a href="{{ route('admin.notifications.index') }}" class="relative inline-flex items-center p-2 text-gray-500 rounded-lg hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @php
                            $unreadCount = \App\Models\AdminNotification::where('admin_id', Auth::id())->where('is_read', false)->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </div>
                @endif
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Beranda') }}
            </x-responsive-nav-link>
            
            <!-- Responsive Relawan Link -->
            <x-responsive-nav-link :href="route('relawan.index')" :active="request()->routeIs('relawan.*')">
                {{ __('Relawan') }}
            </x-responsive-nav-link>
            
            <!-- Responsive Misi Link -->
            <x-responsive-nav-link :href="route('misi.index')" :active="request()->routeIs('misi.*')">
                {{ __('Misi Bantuan') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->usertype === 'admin')
            <!-- Responsive Volunteer Link -->
            <x-responsive-nav-link :href="route('volunteer.index')" :active="request()->routeIs('volunteer.*')">
                {{ __('Volunteer') }}
            </x-responsive-nav-link>
            @endif

            <!-- Responsive Donations Link -->
            <x-responsive-nav-link :href="route('donations.index')" :active="request()->routeIs('donations.*')">
                {{ __('Donasi') }}
            </x-responsive-nav-link>
            
            <!-- Responsive Request Bantuan Link -->
            <x-responsive-nav-link :href="route('admin.request-bantuan.index')" :active="request()->routeIs('admin.request-bantuan.*')">
                {{ __('Request Bantuan') }}
            </x-responsive-nav-link>
            
            <!-- Responsive Edukasi Link -->
            <x-responsive-nav-link :href="route('edukasi.index')" :active="request()->routeIs('edukasi.*')">
                {{ __('Edukasi') }}
            </x-responsive-nav-link>
            
            <!-- Responsive Disaster Report Link -->
            <x-responsive-nav-link :href="route('disaster_report.index')" :active="request()->routeIs('disaster_report.*')">
                {{ __('Laporan Bencana') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->usertype === 'admin')
                <!-- Responsive Admin Dashboard -->
                <x-responsive-nav-link :href="route('admin.faq.index')" :active="request()->routeIs('admin.faq.*')">
                    {{ __('Manajemen FAQ') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dashboard.admin')" :active="request()->routeIs('dashboard.admin')">
                    {{ __('Admin') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
