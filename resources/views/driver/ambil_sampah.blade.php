@extends('layouts.app')

@section('page-title', 'Ambil Sampah')

@section('content')
<div class="flex-1 overflow-y-auto relative bg-[#f5f6fb] p-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Sampah Tersedia</h1>
            <p class="text-gray-600">Pilih pesanan yang ingin Anda ambil</p>
        </div>

        <!-- Filter & Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">{{ $setorSampah->count() }}</h3>
                        <p class="text-gray-600">Pesanan Tersedia</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-truck text-green-500"></i>
                    </div>
                    <div class="ml-4">
                        @php
                            $myActiveOrders = \App\Models\SetorSampah::where('driver_id', auth()->id())
                                                                   ->where('status', 'diambil')
                                                                   ->count();
                        @endphp
                        <div class="flex items-center">
                            <span>{{ $myActiveOrders }}</span>
                        </div>
                        <p class="text-gray-600">Penjemputan Aktif</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-weight-hanging"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">{{ number_format($setorSampah->sum('total_berat'), 2) }} Kg</h3>
                        <p class="text-gray-600">Total Berat</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Pesanan -->
        <div class="space-y-4">
            @forelse($setorSampah as $setor)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <!-- Info Utama -->
                    <div class="flex-1">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-bold text-lg">{{ $setor->user->username }}</h3>
                                <p class="text-gray-600 text-sm">{{ $setor->user->no_telepon }}</p>
                            </div>
                        </div>
                        
                        <!-- Alamat -->
                        <div class="mb-4">
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-red-500 mt-1"></i>
                                <div class="ml-2">
                                    <p class="text-gray-800">{{ $setor->alamat }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Waktu Penjemputan -->
                        <div class="mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-green-500"></i>
                                <div class="ml-2">
                                    <p class="text-gray-800">{{ $setor->tanggal_setor->format('d M Y') }}</p>
                                    <p class="text-gray-600 text-sm">{{ $setor->waktu_setor }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Detail Sampah -->
                        <div class="mb-4">
                            <h4 class="font-semibold mb-2">Detail Sampah:</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                @foreach($setor->setorItems as $item)
                                <div class="flex justify-between items-center bg-gray-50 p-2 rounded">
                                    <span class="text-sm">{{ $item->jenisSampah->nama_sampah }}</span>
                                    <span class="text-sm font-medium">{{ $item->berat }} kg</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Summary -->
                        <div class="grid grid-cols-2 gap-4 p-3 bg-gray-50 rounded">
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Total Berat</p>
                                <p class="font-bold">{{ $setor->total_berat }} kg</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Total Poin</p>
                                <p class="font-bold">{{ $setor->total_poin }} poin</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="mt-4 lg:mt-0 lg:ml-6 flex flex-col space-y-2">
                        <button data-id="{{ $setor->id }}" id="detail-{{ $setor->id }}"
                                class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-eye mr-2"></i>Detail
                        </button>
                        
                        <button data-id="{{ $setor->id }}" id="terima-{{ $setor->id }}"
                                class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors">
                            <i class="fas fa-check mr-2"></i>Terima
                        </button>
                        
                        <button data-id="{{ $setor->id }}" id="tolak-{{ $setor->id }}"
                                class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition-colors">
                            <i class="fas fa-times mr-2"></i>Tolak
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Tidak Ada Pesanan</h3>
                <p class="text-gray-500">Belum ada pesanan sampah yang tersedia untuk diambil.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Terima -->
<div id="terimaModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg max-w-md w-full mx-4">
        <h3 class="text-xl font-bold mb-4">Konfirmasi Terima Pesanan</h3>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin mengambil pesanan ini?</p>
        
        <div class="flex justify-end space-x-3">
            <button onclick="hideTerimaModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded hover:bg-gray-50">
                Batal
            </button>
            <form id="terimaForm" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Ya, Terima
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div id="tolakModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg max-w-md w-full mx-4">
        <h3 class="text-xl font-bold mb-4">Tolak Pesanan</h3>
        
        <form id="tolakForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                <textarea name="alasan" class="w-full border border-gray-300 rounded-lg p-3 h-24" placeholder="Masukkan alasan penolakan..." required></textarea>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="hideTolakModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Tolak Pesanan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk menampilkan modal Detail
    document.querySelectorAll('[id^="detail-"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            console.log('Menampilkan detail untuk pesanan ID:', id);
            alert('Detail pesanan ID: ' + id + ' (Fitur detail lengkap akan datang)');
        });
    });

    // Fungsi untuk menampilkan modal Terima
    document.querySelectorAll('[id^="terima-"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            console.log('Membuka modal Terima untuk pesanan ID:', id);
            document.getElementById('terimaForm').action = `/driver/terima-pesanan/${id}`;
            document.getElementById('terimaModal').classList.remove('hidden');
        });
    });

    // Fungsi untuk menyembunyikan modal Terima
    document.getElementById('terimaModal').addEventListener('click', function(e) {
        if (e.target.id === 'terimaModal') {
            this.classList.add('hidden');
        }
    });

    // Fungsi untuk tombol batal di modal Terima
    document.querySelector('#terimaModal button[onclick^="hideTerimaModal"]').addEventListener('click', function() {
        document.getElementById('terimaModal').classList.add('hidden');
    });

    // Fungsi untuk menampilkan modal Tolak
    document.querySelectorAll('[id^="tolak-"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            console.log('Membuka modal Tolak untuk pesanan ID:', id);
            document.getElementById('tolakForm').action = `/driver/tolak-pesanan/${id}`;
            document.getElementById('tolakModal').classList.remove('hidden');
        });
    });

    // Fungsi untuk menyembunyikan modal Tolak
    document.getElementById('tolakModal').addEventListener('click', function(e) {
        if (e.target.id === 'tolakModal') {
            this.classList.add('hidden');
        }
    });

    // Fungsi untuk tombol batal di modal Tolak
    document.querySelector('#tolakModal button[onclick^="hideTolakModal"]').addEventListener('click', function() {
        document.getElementById('tolakModal').classList.add('hidden');
        document.getElementById('tolakForm').reset();
    });
});
</script>
@endpush
