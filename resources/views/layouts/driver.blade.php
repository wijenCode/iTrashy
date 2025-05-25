<!-- Driver Navigation Component -->
<!-- Tambahkan di layouts/app.blade.php untuk user dengan role driver -->

@if(auth()->check() && auth()->user()->role === 'driver')
<nav class="bg-white shadow-sm border-b mb-4">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex space-x-8">
                <a href="{{ route('driver.ambil.sampah') }}" 
                   class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('driver.ambil.sampah') ? 'bg-blue-100 text-blue-700' : 'text-gray-500 hover:text-gray-700' }}">
                    <i class="fas fa-clipboard-list mr-2"></i>
                    Ambil Sampah
                </a>
                
                <a href="{{ route('driver.penjemputan.saya') }}" 
                   class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('driver.penjemputan.saya') ? 'bg-blue-100 text-blue-700' : 'text-gray-500 hover:text-gray-700' }}">
                    <i class="fas fa-truck mr-2"></i>
                    Penjemputan Saya
                    @php
                        $myPickups = \App\Models\SetorSampah::where('driver_id', auth()->id())
                                                           ->where('status', 'diambil')
                                                           ->count();
                    @endphp
                    @if($myPickups > 0)
                        <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $myPickups }}</span>
                    @endif
                </a>
            </div>
            
            <!-- Stats Summary -->
            <div class="hidden md:flex items-center space-x-6 text-sm text-gray-600">
                @php
                    $availableOrders = \App\Models\SetorSampah::where('status', 'menunggu')->count();
                    $myActiveOrders = \App\Models\SetorSampah::where('driver_id', auth()->id())
                                                           ->where('status', 'diambil')
                                                           ->count();
                @endphp
                
                <div class="flex items-center">
                    <i class="fas fa-list text-blue-500 mr-1"></i>
                    <span>{{ $availableOrders }} Tersedia</span>
                </div>
                
                <div class="flex items-center">
                    <i class="fas fa-truck text-green-500 mr-1"></i>
                    <span>{{ $myActiveOrders }} Aktif</span>
                </div>
            </div>
        </div>
    </div>
</nav>
@endif