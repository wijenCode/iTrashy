<!-- resources/views/layouts/header.blade.php -->
<header class="sticky top-0 bg-white shadow-md z-40">
    <div class="flex items-center justify-between p-4">
        <div class="flex items-center space-x-4">
            <button id="menuToggle" class="lg:hidden">
                <svg class="w-6 h-6" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
            <h2 id="pageTitle" class="text-lg font-semibold">
                <!-- Dynamic Title -->
                @yield('page-title', 'Dashboard')
            </h2>
        </div>
        
        <div class="flex items-center space-x-4 relative">
            <!-- Notifikasi -->
            <div class="relative" x-data="{ openNotif: false }">
                <button id="notifIcon" class="focus:outline-none" @click="openNotif = !openNotif">
                    <img src="{{ asset('storage/images/notifikasi.png') }}" alt="Notifications" class="w-8 h-8">
                    <!-- Badge -->
                    <span id="notifBadge" class="absolute top-0 right-0 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        0 <!-- Static count (for demo purposes) -->
                    </span>
                </button>
                <!-- Dropdown Notifikasi -->
                <div x-show="openNotif" @click.away="openNotif = false" x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50 border border-gray-100">
                    <div class="p-4 border-b font-bold text-gray-700">Notifikasi</div>
                    <ul class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                        <!-- Dummy notifikasi, ganti dengan loop jika sudah ada data -->
                        <li class="p-4 hover:bg-gray-50 cursor-pointer flex items-start gap-3">
                            <span class="bg-green-100 text-green-600 rounded-full p-2 mt-1"><i class="fas fa-check-circle"></i></span>
                            <div>
                                <div class="font-semibold text-sm">Setor Sampah Diterima</div>
                                <div class="text-xs text-gray-500">Setoran sampah kamu sudah diterima dan sedang diproses.</div>
                                <div class="text-xs text-gray-400 mt-1">Baru saja</div>
                            </div>
                        </li>
                        <li class="p-4 hover:bg-gray-50 cursor-pointer flex items-start gap-3">
                            <span class="bg-blue-100 text-blue-600 rounded-full p-2 mt-1"><i class="fas fa-ticket-alt"></i></span>
                            <div>
                                <div class="font-semibold text-sm">Tukar Voucher Berhasil</div>
                                <div class="text-xs text-gray-500">Penukaran voucher berhasil! Silakan cek riwayat.</div>
                                <div class="text-xs text-gray-400 mt-1">2 menit lalu</div>
                            </div>
                        </li>
                        <li class="p-4 hover:bg-gray-50 cursor-pointer flex items-start gap-3">
                            <span class="bg-yellow-100 text-yellow-600 rounded-full p-2 mt-1"><i class="fas fa-exchange-alt"></i></span>
                            <div>
                                <div class="font-semibold text-sm">Transfer Berhasil</div>
                                <div class="text-xs text-gray-500">Transfer poin ke Budi berhasil.</div>
                                <div class="text-xs text-gray-400 mt-1">5 menit lalu</div>
                            </div>
                        </li>
                    </ul>
                    <div class="p-2 text-center border-t"><a href="/riwayat" class="text-blue-600 text-sm hover:underline">Lihat Semua Riwayat</a></div>
                </div>
            </div>

            <!-- Divider -->
            <div class="w-px h-10 bg-black"></div>
            
            <!-- Profile Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <!-- Profile Image -->
                <button @click="open = ! open" class="focus:outline-none">
                    <img src="{{ asset('storage/images/profile.jpg') }}" alt="Profile" class="w-10 h-10 rounded-full">
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10">
                    <div class="py-1">
                        <!-- Profile Link -->
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Profile') }}
                        </a>

                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@include('user.notifikasi.index')
