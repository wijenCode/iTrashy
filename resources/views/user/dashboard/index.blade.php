@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="flex h-screen overflow-hidden">
    <div class="flex-1 flex flex-col min-h-screen lg:ml-0">
        <div>
            <div class="flex flex-col lg:grid lg:grid-cols-3 lg:gap-5">
                <div class="lg:col-span-2 space-y-5 order-1">
                    <div class="relative overflow-hidden rounded-lg shadow-lg">
                        <div id="slider" class="flex w-full">
                            <img src="{{ asset('storage/images/poster1.png') }}" alt="Banner 1" class="w-full">
                            <img src="{{ asset('storage/images/poster2.png') }}" alt="Banner 2" class="w-full">
                            <img src="{{ asset('storage/images/poster3.png') }}" alt="Banner 3" class="w-full">
                        </div>
                    </div>

                    <!-- Balance & Actions -->
                    <div class="bg-gradient-to-r from-[#FED4B4] to-[#54B68B] p-4 rounded-lg">
                        <div class="flex lg:flex-row md:justify-around lg:justify-around justify-between">
                            <!-- Points Display -->
                            <div class="flex items-center space-x-2 justify-center">
                                <img src="{{ asset('storage/images/poin logo.png') }}" alt="Poin" class="md:w-10 lg:w-10 w-8">
                                <h4 class="text-xl lg:text-2xl font-bold">{{ number_format(Auth::user()->poin_terkumpul, 0, ',', '.') }}</h4>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex lg:justify-end space-x-5 lg:space-x-16 md:space-x-16">
                                @php
                                    $actions = [
                                        ['name' => 'Transfer', 'icon' => 'transfer.png', 'link' => route('transfer.index')],
                                        ['name' => 'Sembako', 'icon' => 'sembako.png', 'link' => route('tukar_poin.index')],
                                        ['name' => 'Voucher', 'icon' => 'sembako.png', 'link' => route('tukar_poin.index')],
                                        ['name' => 'Donasi', 'icon' => 'donasi.png', 'link' => route('donasi.index')]
                                    ];
                                @endphp

                                @foreach ($actions as $action)
                                    <a href="{{ $action['link'] }}">
                                        <div class="flex flex-col items-center">
                                            <button class="bg-white rounded-xl w-10 h-10 lg:w-12 lg:h-12 md:w-12 md:h-12 flex items-center justify-center shadow hover:bg-gray-50">
                                                <img src="{{ asset('assets/icon/' . $action['icon']) }}" alt="{{ $action['name'] }}" class="md:w-6 md:h-6 lg:w-6 lg:h-6 w-5 h-5">
                                            </button>
                                            <span class="lg:text-sm md:text-sm text-xs mt-2">{{ $action['name'] }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:block">
                        <h3 class="text-xl font-bold mb-4">Edukasi Terbaru</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach ($edukasiItems as $item)
                                <div class="bg-white rounded-lg shadow-md p-3">
                                    <a href="#">
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul_konten }}" class="w-full h-32 md:h-40 object-cover rounded-lg">
                                        <h4 class="font-semibold mt-2">{{ $item->judul_konten }}</h4>
                                        <p class="text-sm text-gray-500 mt-1">{{ $item->kategori }}</p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="space-y-4 mt-10 lg:mt-0 lg:bg-white lg:p-5 lg:rounded-lg order-2 lg:order-3">
<<<<<<< HEAD
=======
                    <!-- Jadwal Penjemputan Container -->
                    <div class="bg-white lg:bg-[#f5f6fb] rounded-lg shadow p-4">
                        <h4 class="font-bold text-lg mb-3">Jadwal Penjemputan</h4>
                        @if(count($setorSampah) > 0)
                            <div class="space-y-3 max-h-[220px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent hover:scrollbar-thumb-gray-400">
                                @foreach($setorSampah as $setor)
                                    <div class="bg-white rounded-lg shadow-sm p-3 border-l-4 
                                        @if($setor->status == 'menunggu') border-yellow-500
                                        @elseif($setor->status == 'dikonfirmasi') border-blue-500
                                        @elseif($setor->status == 'dalam_penjemputan') border-purple-500
                                        @elseif($setor->status == 'selesai') border-green-500
                                        @else border-gray-500 @endif">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-medium">{{ \Carbon\Carbon::parse($setor->tanggal_setor)->format('d M Y') }}</p>
                                                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($setor->waktu_setor)->format('H:i') }} WIB</p>
                                                <p class="text-xs text-gray-500 mt-1 truncate max-w-[180px]">{{ $setor->alamat }}</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($setor->status == 'menunggu') bg-yellow-100 text-yellow-800
                                                @elseif($setor->status == 'dikonfirmasi') bg-blue-100 text-blue-800
                                                @elseif($setor->status == 'dalam_penjemputan') bg-purple-100 text-purple-800
                                                @elseif($setor->status == 'selesai') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $setor->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-6 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500">Belum ada jadwal penjemputan</p>
                                <a href="{{ route('setor.sampah') }}" class="mt-3 text-sm text-blue-600 hover:underline">Setor sampah sekarang</a>
                            </div>
                        @endif
                    </div>

                    <!-- Sampah Terkumpul Chart -->
>>>>>>> 4f2933e08faf514621e9a28e97b16ab2372b9c2c
                    <div class="bg-white lg:bg-[#f5f6fb] rounded-lg shadow p-4 h-[220px]">
                        <h4 class="font-bold text-lg mb-3">Sampah Terkumpul</h4>
                        <div class="h-[150px]">
                            <canvas id="garbageChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white lg:bg-[#f5f6fb] rounded-lg shadow p-4 h-[220px]">
                        <h4 class="font-bold text-lg mb-3">Jejak Karbon Terkurangi</h4>
                        <div class="h-[150px]">
                            <canvas id="carbonChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
});

function initializeCharts() {
    const chartConfig = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true
            }
        }
    };

    // Example data
    const garbageData = [10, 20, 30, 40, 50];
    const carbonData = [5, 15, 25, 35, 45];

    // Garbage Chart
    new Chart(document.getElementById('garbageChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                label: 'Sampah Terkumpul (kg)',
                data: garbageData,
                backgroundColor: '#6C63FF',
                borderRadius: 5,
                barThickness: 20
            }]
        },
        options: chartConfig
    });

    // Carbon Chart
    const carbonCtx = document.getElementById('carbonChart').getContext('2d');
    const gradient = carbonCtx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, 'rgba(108, 99, 255, 0.5)');
    gradient.addColorStop(1, 'rgba(108, 99, 255, 0)');

    new Chart(carbonCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                label: 'Jejak Karbon Terkurangi (kg CO₂)',
                data: carbonData,
                borderColor: '#6C63FF',
                backgroundColor: gradient,
                fill: true,
                tension: 0.4
            }]
        },
        options: chartConfig
    });
}
</script>
@endpush