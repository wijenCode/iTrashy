@extends('layouts.app')

@section('page-title', 'Riwayat Setor Sampah')

@section('content')
<div class="flex-1 overflow-y-auto relative bg-[#f5f6fb] p-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Riwayat Setor Sampah</h1>
                    <p class="text-gray-600">Daftar semua pesanan setor sampah Anda</p>
                </div>
                <a href="{{ route('setor.sampah') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    <i class="fas fa-plus mr-2"></i>Setor Baru
                </a>
            </div>
        </div>

        <!-- Filter dan Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">{{ $setorSampah->total() }}</h3>
                        <p class="text-gray-600 text-sm">Total Pesanan</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">{{ $setorSampah->where('status', 'menunggu')->count() }}</h3>
                        <p class="text-gray-600 text-sm">Menunggu</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">{{ $setorSampah->where('status', 'diambil')->count() }}</h3>
                        <p class="text-gray-600 text-sm">Dijemput</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">{{ $setorSampah->where('status', 'selesai')->count() }}</h3>
                        <p class="text-gray-600 text-sm">Selesai</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- List Riwayat -->
        <div class="space-y-4">
            @forelse($setorSampah as $setor)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start">
                    <!-- Info Utama -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-bold text-lg">Pesanan #{{ $setor->id }}</h3>
                                <p class="text-gray-600 text-sm">{{ $setor->created_at->format('d M Y H:i') }}</p>
                            </div>
                            
                            <!-- Status Badge -->
                            <div>
                                @if($setor->status === 'menunggu')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>Menunggu
                                    </span>
                                @elseif($setor->status === 'diambil')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-truck mr-1"></i>Dijemput
                                    </span>
                                @elseif($setor->status === 'selesai')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Selesai
                                    </span>
                                @elseif($setor->status === 'ditolak')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Detail Singkat -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Jadwal -->
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-green-500"></i>
                                <div class="ml-2">
                                    <p class="text-sm text-gray-600">Jadwal Penjemputan</p>
                                    <p class="text-gray-800">{{ $setor->tanggal_setor->format('d M Y') }}</p>
                                    <p class="text-gray-600 text-sm">{{ $setor->waktu_setor }}</p>
                                </div>
                            </div>
                            
                            <!-- Driver (jika ada) -->
                            @if($setor->driver)
                            <div class="flex items-center">
                                <i class="fas fa-user text-blue-500"></i>
                                <div class="ml-2">
                                    <p class="text-sm text-gray-600">Driver</p>
                                    <p class="text-gray-800">{{ $setor->driver->username }}</p>
                                    <p class="text-gray-600 text-sm">{{ $setor->driver->no_telepon }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Summary -->
                        <div class="grid grid-cols-3 gap-4 p-3 bg-gray-50 rounded">
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Items</p>
                                <p class="font-bold">{{ $setor->setorItems->count() }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Berat</p>
                                <p class="font-bold">{{ $setor->total_berat }} kg</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Poin</p>
                                <p class="font-bold text-green-600">{{ $setor->total_poin }}</p>
                            </div>
                        </div>

                        <!-- Kode Kredensial (jika status diambil) -->
                        @if($setor->status === 'diambil' && $setor->kode_kredensial)
                        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-yellow-800">Kode Kredensial</p>
                                    <p class="text-xs text-yellow-600">Berikan kepada driver saat penimbangan</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-lg font-mono font-bold text-yellow-800">{{ $setor->kode_kredensial }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Action Button -->
                    <div class="mt-4 lg:mt-0 lg:ml-6">
                        <a href="{{ route('setor.sampah.detail', $setor->id) }}" 
                           class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors inline-block">
                            <i class="fas fa-eye mr-2"></i>Detail
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <i class="fas fa-history text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum Ada Riwayat</h3>
                <p class="text-gray-500 mb-4">Anda belum pernah melakukan setor sampah.</p>
                <a href="{{ route('setor.sampah') }}" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600">
                    <i class="fas fa-plus mr-2"></i>Setor Sampah Sekarang
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($setorSampah->hasPages())
        <div class="mt-6">
            {{ $setorSampah->links() }}
        </div>
        @endif
    </div>
</div>
@endsection