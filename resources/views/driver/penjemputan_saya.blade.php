@extends('layouts.app')

@section('page-title', 'Penjemputan Saya')

@section('content')
<div class="flex-1 overflow-y-auto relative bg-[#f5f6fb] p-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Penjemputan Saya</h1>
            <p class="text-gray-600">Daftar pesanan yang sudah Anda terima</p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">{{ $setorSampah->count() }}</h3>
                        <p class="text-gray-600">Pesanan Diambil</p>
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

        <!-- Daftar Penjemputan -->
        <div class="space-y-4">
            @forelse($setorSampah as $setor)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex flex-col lg:flex-row lg:justify-between">
                    <!-- Info Utama -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-bold text-lg">{{ $setor->user->username }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $setor->user->no_telepon }}</p>
                                </div>
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
                        
                        <!-- Waktu -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-green-500"></i>
                                <div class="ml-2">
                                    <p class="text-sm text-gray-600">Jadwal Penjemputan</p>
                                    <p class="text-gray-800">{{ $setor->tanggal_setor->format('d M Y') }}</p>
                                    <p class="text-gray-600 text-sm">{{ $setor->waktu_setor }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-clock text-blue-500"></i>
                                <div class="ml-2">
                                    <p class="text-sm text-gray-600">Waktu Diambil</p>
                                    <p class="text-gray-800">{{ $setor->tanggal_diambil->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Detail Sampah -->
                        <div class="mb-4">
                            <h4 class="font-semibold mb-2">Detail Sampah:</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2" id="sampahList-{{ $setor->id }}">
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
                        <button data-id="{{ $setor->id }}" id="edit-{{ $setor->id }}"
                                class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 transition-colors">
                            <i class="fas fa-edit mr-2"></i>Edit Data
                        </button>
                        
                        <button data-id="{{ $setor->id }}" id="selesai-{{ $setor->id }}"
                                class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors">
                            <i class="fas fa-check-circle mr-2"></i>Selesai
                        </button>
                        
                        <button data-id="{{ $setor->id }}" id="detail-{{ $setor->id }}"
                                class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-eye mr-2"></i>Detail
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <i class="fas fa-truck text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum Ada Penjemputan</h3>
                <p class="text-gray-500">Anda belum mengambil pesanan apapun.</p>
                <a href="{{ route('driver.ambil.sampah') }}" class="inline-block mt-4 bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                    Ambil Pesanan
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg max-w-2xl w-full mx-4 max-h-screen overflow-y-auto">
        <h3 class="text-xl font-bold mb-4">Edit Data Penjemputan</h3>
        
        <form id="editForm" method="POST">
            @csrf
            <!-- Input Kode Kredensial -->
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-key mr-2"></i>Kode Kredensial dari Pengguna
                </label>
                <input type="text" name="kode_kredensial" class="w-full border border-gray-300 rounded-lg p-3 text-center font-mono font-bold uppercase tracking-wider" 
                       placeholder="Masukkan kode dari pengguna" required>
                <p class="text-xs text-gray-600 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Minta kode kredensial kepada pengguna sebelum mengedit data
                </p>
            </div>
            
            <!-- Edit Berat Sampah -->
            <div class="mb-6">
                <h4 class="font-semibold mb-3">Berat Sampah Aktual:</h4>
                <div id="editSampahList" class="space-y-3">
                    <!-- Akan diisi via JavaScript -->
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="hideEditModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Selesai -->
<div id="selesaiModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg max-w-md w-full mx-4">
        <h3 class="text-xl font-bold mb-4">Selesaikan Penjemputan</h3>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menyelesaikan penjemputan ini?</p>
        <p class="text-sm text-red-600 mb-6">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Pastikan data sudah diedit sesuai dengan berat aktual sebelum menyelesaikan!
        </p>
        
        <div class="flex justify-end space-x-3">
            <button onclick="hideSelesaiModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded hover:bg-gray-50">
                Batal
            </button>
            <form id="selesaiForm" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Ya, Selesaikan
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentSetorData = null;

document.addEventListener('DOMContentLoaded', function() {
    // Dapatkan semua data setor sampah dari Blade sebagai JSON
    const allSetorSampahData = @json($setorSampah);

    // Event Listener untuk tombol Edit Data
    document.querySelectorAll('[id^="edit-"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            currentSetorData = allSetorSampahData.find(item => item.id == id);
            
            if (!currentSetorData) return;
            
            // Set form action
            document.getElementById('editForm').action = `/driver/edit-penjemputan/${id}`;
            
            // Generate form fields untuk edit berat
            const editSampahList = document.getElementById('editSampahList');
            editSampahList.innerHTML = '';
            
            currentSetorData.setor_items.forEach((item, index) => {
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between bg-gray-50 p-3 rounded';
                div.innerHTML = `
                    <div class="flex-1">
                        <span class="font-medium">${item.jenis_sampah.nama_sampah}</span>
                        <span class="text-sm text-gray-600 block">${item.jenis_sampah.poin_per_kg} poin/kg</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="button" class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-full hover:bg-red-200" data-index="${index}" data-change="-0.01">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <input type="number" name="sampah_berat[]" 
                               id="berat_${index}" 
                               value="${item.berat}" 
                               step="0.01" 
                               min="0" 
                               class="w-20 text-center border border-gray-300 rounded px-2 py-1" data-index="${index}">
                        <span class="text-sm">kg</span>
                        <button type="button" class="w-8 h-8 flex items-center justify-center bg-green-100 text-green-600 rounded-full hover:bg-green-200" data-index="${index}" data-change="0.25">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                `;
                editSampahList.appendChild(div);
            });

            // Attach event listeners for changeBerat and updateBerat to the new elements
            editSampahList.querySelectorAll('button[data-change]').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    const change = parseFloat(this.dataset.change);
                    changeBerat(index, change);
                });
            });

            editSampahList.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('change', function() {
                    const index = parseInt(this.dataset.index);
                    updateBerat(index, this.value);
                });
            });
            
            document.getElementById('editModal').classList.remove('hidden');
        });
    });

    // Fungsi untuk menyembunyikan modal Edit
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target.id === 'editModal') {
            this.classList.add('hidden');
            document.getElementById('editForm').reset(); // Reset form saat modal disembunyikan
        }
    });

    // Fungsi untuk tombol batal di modal Edit
    document.querySelector('#editModal button[type="button"]').addEventListener('click', function() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editForm').reset();
    });

    // Event Listener untuk tombol Selesai
    document.querySelectorAll('[id^="selesai-"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            document.getElementById('selesaiForm').action = `/driver/selesaikan-penjemputan/${id}`;
            document.getElementById('selesaiModal').classList.remove('hidden');
        });
    });

    // Fungsi untuk menyembunyikan modal Selesai
    document.getElementById('selesaiModal').addEventListener('click', function(e) {
        if (e.target.id === 'selesaiModal') {
            this.classList.add('hidden');
        }
    });

    // Fungsi untuk tombol batal di modal Selesai
    document.querySelector('#selesaiModal button[onclick^="hideSelesaiModal"]').addEventListener('click', function() {
        document.getElementById('selesaiModal').classList.add('hidden');
    });

    // Event Listener untuk tombol Detail
    document.querySelectorAll('[id^="detail-"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            console.log('Menampilkan detail untuk pesanan ID:', id);
            alert('Detail pesanan ID: ' + id + ' (Fitur detail lengkap akan datang)');
        });
    });

    // Fungsi helper untuk mengubah berat (memperbaiki syntax error)
    function changeBerat(index, change) {
        const input = document.getElementById(`berat_${index}`);
        const newValue = Math.max(0, parseFloat(input.value) + change);
        input.value = newValue.toFixed(2);
    }

    // Fungsi helper untuk memperbarui berat (memperbaiki syntax error)
    function updateBerat(index, value) {
        const input = document.getElementById(`berat_${index}`);
        input.value = Math.max(0, parseFloat(value)).toFixed(2);
    }
});

</script>
@endpush
