<div id="menu" class="fixed top-0 left-0 w-60 h-full bg-white shadow-lg transform -translate-x-full transition-transform duration-300 z-50 lg:translate-x-0 lg:static lg:w-[230px]">
    <div class="p-5 flex items-center justify-between lg:justify-start space-x-4">
        <img src="{{ asset('storage/images/Logo Itrashy.png') }}" alt="Logo Itrashy" class="w-8 h-10">
        <h1 class="text-lg font-semibold lg:block hidden">I-Trashy</h1>
        <button id="menuClose" class="lg:hidden">
            <svg class="w-6 h-6" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="bg-gradient-to-r from-[#FED4B4] to-[#54B68B] mt-4 pt-2 pb-2 ml-5 mr-5 rounded-lg shadow-lg">
        <div class="flex flex-col items-start pl-10">
            <p class="text-sm pb-1">Poin Anda</p>
            <div class="flex space-x-2 justify-center">
                <img src="{{ asset('storage/images/poin.png') }}" alt="Poin" class="h-6 w-6">
                <h4 class="text-xl lg:text-xl font-bold">
                    {{ number_format(Auth::user()->poin_terkumpul, 0, ',', '.') }}
                </h4>
            </div>    
        </div>
    </div>

    <nav class="p-5 mt-5 space-y-8">
        <a href="{{ url('/dashboard') }}" class="nav-link flex items-center space-x-4 hover:bg-gray-200 hover:ml-[-20px] hover:pl-[30px] hover:pr-[5px] hover:py-[10px] hover:font-medium hover:rounded-r-xl transition-all duration-300">
            <img src="{{ asset('storage/images/dashboard.png') }}" alt="Dashboard Icon" class="w-5 h-5">
            <span>Dashboard</span>
        </a>
        <a href="{{ url('/setor-sampah') }}" class="nav-link flex items-center space-x-4 hover:bg-gray-200 hover:ml-[-20px] hover:pl-[30px] hover:pr-[5px] hover:py-[10px] hover:font-medium hover:rounded-r-xl transition-all duration-300">
            <img src="{{ asset('storage/images/setor.png') }}" alt="Setor Sampah Icon" class="w-6 h-6">
            <span>Setor Sampah</span>
        </a>
        <a href="{{ route('tukar_poin.index') }}" class="nav-link flex items-center space-x-4 hover:bg-gray-200 hover:ml-[-20px] hover:pl-[30px] hover:pr-[5px] hover:py-[10px] hover:font-medium hover:rounded-r-xl transition-all duration-300">
            <img src="{{ asset('storage/images/poin black.png') }}" alt="Tukar Poin Icon" class="w-5 h-5">
            <span>Tukar Poin</span>
        </a>    
        <a href="{{ route('edukasi.index') }}" class="nav-link flex items-center space-x-4 hover:bg-gray-200 hover:ml-[-20px] hover:pl-[30px] hover:pr-[5px] hover:py-[10px] hover:font-medium hover:rounded-r-xl transition-all duration-300">
            <img src="{{ asset('storage/images/edukasi.png') }}" alt="Edukasi Icon" class="w-5 h-5">
            <span>Edukasi</span>
        </a>
        <a href="{{ route('user.pencapaian.index') }}" class="nav-link flex items-center space-x-4 hover:bg-gray-200 hover:ml-[-20px] hover:pl-[30px] hover:pr-[5px] hover:py-[10px] hover:font-medium hover:rounded-r-xl transition-all duration-300">
            <img src="{{ asset('storage/images/pencapaian.png') }}" alt="Pencapaian Icon" class="w-6 h-6">
            <span>Pencapaian</span>
        </a>
        <a href="#" class="nav-link flex items-center space-x-4 hover:bg-gray-200 hover:ml-[-20px] hover:pl-[30px] hover:pr-[5px] hover:py-[10px] hover:font-medium hover:rounded-r-xl transition-all duration-300">
            <img src="{{ asset('storage/images/riwayat.png') }}" alt="Riwayat Icon" class="w-6 h-6">
            <span>Riwayat</span>
        </a>
    </nav>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        initializeMenu();
    });

    function initializeMenu() {
        const menuClose = document.getElementById('menuClose');
        const menu = document.getElementById('menu');
        const navLinks = document.querySelectorAll('.nav-link');
        
        // Mobile menu toggles
        if (menuClose && menu) {
            menuClose.addEventListener('click', () => menu.classList.add('-translate-x-full'));
        }

        // Set active menu item
        const currentPage = window.location.pathname.split('/').pop();
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href.includes(currentPage)) {
                link.classList.add('bg-[#3968DA]', 'text-white', 'ml-[-20px]', 'pl-[30px]', 'pr-[5px]', 'py-[10px]', 'font-medium', 'rounded-r-2xl');
            }
        });
    }
</script>
@endpush