@extends('layouts.app')

@section('page-title', 'Detail Setor Sampah')

@section('content')
<div class="flex-1 overflow-y-auto relative bg-[#f5f6fb] p-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Detail Setor Sampah</h1>
                    <p class="text-gray-600">Status: {{ ucfirst($setorSampah->status) }}</p>
                </div>
                <a href="{{ route('dashboard.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Kode Kredensial Card - Selalu tampil untuk user -->
        <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-lg shadow-lg p-6 mb-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-2">
                        <i class="fas fa-key mr-2"></i>Kode Kredensial Anda
                    </h3>
                    <p class="text-yellow-100 text-sm mb-3">
                        Berikan kode ini kepada driver saat mereka menimbang sampah Anda
                    </p>
                    <div class="bg-white bg-opacity-20 rounded-lg px-6 py-4 inline-block">
                        <span class="text-3xl font-mono font-bold tracking-wider">
                            {{ $setorSampah->kode_kredensial }}
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <p class="text-xs text-yellow-100 mt-2">Jaga kerahasiaan<br>kode ini</p>
                </div>
            </div>
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Status Pesanan</h3>
                    @if($setorSampah->status === 'menunggu')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-2"></i>Menunggu Driver
                        </span>
                        <p class="text-sm text-gray-600 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Pesanan Anda sedang menunggu driver. Siapkan kode kredensial di atas.
                        </p>
                    @elseif($setorSampah->status === 'dikonfirmasi')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-truck mr-2"></i>Sedang Dijemput
                        </span>
                        <p class="text-sm text-gray-600 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Driver sedang dalam perjalanan menuju lokasi Anda. Siapkan kode kredensial.
                        </p>
                    @elseif($setorSampah->status === 'selesai')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-2"></i>Selesai
                        </span>
                        <p class="text-sm text-gray-600 mt-2">
                            <i class="fas fa-check mr-1"></i>
                            Penjemputan selesai. Poin Anda telah ditambahkan ke akun.
                        </p>
                    @elseif($setorSampah->status === 'ditolak')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-2"></i>Ditolak
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Info Driver (jika ada) -->
        @if($setorSampah->driver)
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Informasi Driver</h3>
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <h4 class="font-semibold">{{ $setorSampah->driver->username }}</h4>
                    <p class="text-gray-600 text-sm">{{ $setorSampah->driver->no_telepon }}</p>
                    @if($setorSampah->tanggal_diambil)
                    <p class="text-gray-500 text-xs">Diambil: {{ $setorSampah->tanggal_diambil->format('d M Y H:i') }}</p>
                    @endif
                </div>
            </div>
            
            @if($setorSampah->status === 'dikonfirmasi')
            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-phone mr-2"></i>
                    Anda dapat menghubungi driver untuk koordinasi penjemputan.
                </p>
            </div>
            @endif
        </div>
        @endif

        <!-- Detail Penjemputan -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Detail Penjemputan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Alamat -->
                <div>
                    <h4 class="font-medium text-gray-700 mb-2">Alamat Penjemputan</h4>
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-red-500 mt-1"></i>
                        <p class="ml-2 text-gray-800">{{ $setorSampah->alamat }}</p>
                    </div>
                </div>
                
                <!-- Waktu -->
                <div>
                    <h4 class="font-medium text-gray-700 mb-2">Jadwal Penjemputan</h4>
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt text-green-500"></i>
                        <div class="ml-2">
                            <p class="text-gray-800">{{ $setorSampah->tanggal_setor->format('d M Y') }}</p>
                            <p class="text-gray-600 text-sm">{{ $setorSampah->waktu_setor }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Sampah -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Detail Sampah</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Jenis Sampah</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">Berat (kg)</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">Poin/kg</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-gray-700">Total Poin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($setorSampah->setorItems as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . $item->jenisSampah->gambar) }}" 
                                         alt="{{ $item->jenisSampah->nama_sampah }}" 
                                         class="w-10 h-10 object-cover rounded-lg mr-3">
                                    <span class="font-medium">{{ $item->jenisSampah->nama_sampah }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">{{ $item->berat }} kg</td>
                            <td class="px-4 py-3 text-center">{{ $item->jenisSampah->poin_per_kg }}</td>
                            <td class="px-4 py-3 text-center font-semibold">{{ $item->poin }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Summary -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="flex justify-between items-center text-lg font-semibold">
                    <span>Total:</span>
                    <div class="text-right">
                        <p>{{ $setorSampah->total_berat }} kg</p>
                        <p class="text-green-600">{{ $setorSampah->total_poin }} poin</p>
                    </div>
                </div>
                
                @if($setorSampah->status !== 'selesai')
                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Catatan:</strong> Berat dan poin di atas adalah estimasi awal. 
                        Driver akan menimbang ulang sampah Anda untuk mendapatkan berat dan poin yang akurat.
                    </p>
                </div>
                @endif
            </div>
        </div>

        <!-- Catatan (jika ada) -->
        @if($setorSampah->catatan_driver)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Catatan Driver</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-700">{{ $setorSampah->catatan_driver }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection