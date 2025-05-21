@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 overflow-y-auto">
    <div class="container mx-auto p-6 space-y-8">
        <!-- Header -->
        <h2 class="text-2xl font-bold text-gray-800 text-center sm:text-left">
            Yuk, Lihat Statistik Pencapaianmu!
        </h2>

        <!-- Main Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Statistik Section -->
            <div class="col-span-1 lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Sampah Terkumpul -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800">Jejak Sampah Terkumpul</h3>
                    <div class="h-[300px]">
                        <canvas id="garbageChart" class="my-4"></canvas>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalWeight }} Kg</p>
                    <p class="text-gray-500 text-sm">
                        Ayo setorkan sampahmu!
                    </p>
                </div>

                <!-- Grafik Jejak Karbon -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800">Jejak Karbon</h3>
                    <div class="h-[300px]">
                        <canvas id="carbonChart" class="my-4"></canvas>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalCarbonReduced }} Kg CO₂</p>
                    <p class="text-gray-500 text-sm">
                        Ayo olah sampahmu untuk kurangi jejak karbonmu!
                    </p>
                </div>
            </div>

            <!-- Leaderboard -->
            <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
                <h3 class="text-3xl font-bold text-center border-b border-purple-600 pb-4">Leaderboard</h3>
                
                <!-- Scrollable Area -->
                <div class="mt-4 space-y-4 max-h-[400px] overflow-y-auto scrollbar-thin scrollbar-thumb-purple-500 scrollbar-track-purple-300">
                    @forelse($leaderboard as $index => $user)
                        <div class="flex items-center bg-gray-200 p-4 rounded-lg shadow-sm hover:bg-purple-600 transition">
                            <!-- Rank -->
                            <div class="flex items-center justify-center bg-white font-bold text-xl w-12 h-12 rounded-full">
                                {{ $index + 1 }}
                            </div>
                            <!-- Profile -->
                            <div class="ml-4 flex-shrink-0">
                                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('assets/icon/user.png') }}" 
                                     alt="Avatar" 
                                     class="w-14 h-14 rounded-full">
                            </div>
                            <!-- User Info -->
                            <div class="ml-4">
                                <h3 class="text-lg font-medium">{{ $user->username }}</h3>
                                <p class="text-sm">Total Berat: <strong>{{ $user->total_weight }} Kg</strong></p>
                            </div>
                        </div>
                    @empty
                        <p class="text-purple-200 text-center">Belum ada data untuk ditampilkan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Most Collected Waste -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Paling Sering Dikumpulkan</h3>
            <div id="waste-list" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($wasteData as $waste)
                    <div class="flex items-center space-x-4 bg-white p-4 rounded-lg shadow-md">
                        <img src="{{ asset('assets/image/' . $waste->image) }}" 
                             alt="{{ $waste->waste_type }}" 
                             class="w-12 h-12">
                        <div>
                            <p class="font-bold text-gray-800">{{ $waste->waste_type }}</p>
                            <p class="text-sm text-gray-500">{{ $waste->total_quantity }} Kg</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Tidak ada data sampah yang ditemukan untuk pengguna ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
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

    // Data dari controller
    const garbageData = @json($garbageData);
    const carbonData = @json($carbonData);

    // Garbage Chart
    const garbageChart = new Chart(document.getElementById('garbageChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: garbageData.map(item => item.month),
            datasets: [{
                label: 'Sampah Terkumpul (kg)',
                data: garbageData.map(item => item.total_weight),
                backgroundColor: '#6C63FF',
                borderRadius: 5,
                barThickness: 20,
            }]
        },
        options: chartConfig
    });

    // Carbon Chart
    const carbonCtx = document.getElementById('carbonChart').getContext('2d');
    const gradient = carbonCtx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, 'rgba(108, 99, 255, 0.5)');
    gradient.addColorStop(1, 'rgba(108, 99, 255, 0)');

    const carbonChart = new Chart(carbonCtx, {
        type: 'line',
        data: {
            labels: carbonData.map(item => item.month),
            datasets: [{
                label: 'Jejak Karbon Terkurangi (kg CO₂)',
                data: carbonData.map(item => item.carbon),
                borderColor: '#6C63FF',
                backgroundColor: gradient,
                fill: true,
                tension: 0.4
            }]
        },
        options: chartConfig
    });
});
</script>
@endpush
@endsection

