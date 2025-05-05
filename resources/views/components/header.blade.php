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
            <div class="relative">
                <button id="notifIcon" class="focus:outline-none">
                    <img src="{{ asset('storage/images/notifikasi.png') }}" alt="Notifications" class="w-8 h-8">
                    <!-- Badge -->
                    <span id="notifBadge" class="absolute top-0 right-0 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        0 <!-- Static count (for demo purposes) -->
                    </span>
                </button>
            </div>

            <!-- Divider -->
            <div class="w-px h-10 bg-black"></div>
            
            <!-- Profile -->
            <a href="profile">
                <img src="{{ asset('storage/images/profile.jpg') }}" alt="Profile" class="w-10 h-10 rounded-full">
            </a>
        </div>
    </div>
</header>
