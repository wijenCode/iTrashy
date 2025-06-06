@extends('layouts.app')
@section('page-title', 'Riwayat Transaksi')
@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto bg-white rounded-lg shadow p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div class="flex space-x-4 mb-4 md:mb-0">
                <button class="tab-riwayat px-4 py-2 font-semibold border-b-2 border-blue-600 text-blue-600 focus:outline-none" data-type="Semua">Semua</button>
                <button class="tab-riwayat px-4 py-2 font-semibold text-gray-500 hover:text-blue-600 focus:outline-none" data-type="Setor Sampah">Jemput Sampah</button>
                <button class="tab-riwayat px-4 py-2 font-semibold text-gray-500 hover:text-blue-600 focus:outline-none" data-type="Transfer">Transfer</button>
                <button class="tab-riwayat px-4 py-2 font-semibold text-gray-500 hover:text-blue-600 focus:outline-none" data-type="Voucher">Tukar Poin</button>
                <button class="tab-riwayat px-4 py-2 font-semibold text-gray-500 hover:text-blue-600 focus:outline-none" data-type="Donasi">Donasi</button>
            </div>
            <div class="flex items-center space-x-2">
                <input type="text" id="searchRiwayat" placeholder="Cari" class="border rounded px-3 py-2 text-sm w-48">
                <div class="relative">
                    <button id="filterDropdownBtn" class="bg-gray-100 px-3 py-2 rounded text-gray-600 hover:bg-gray-200 flex items-center">
                        <i class="fas fa-filter mr-1"></i> Filter
                        <i class="fas fa-chevron-down ml-1"></i>
                    </button>
                    <div id="filterDropdown" class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg z-10 hidden">
                        <button class="filter-status w-full text-left px-4 py-2 hover:bg-gray-100" data-status="Semua">Semua Status</button>
                        <button class="filter-status w-full text-left px-4 py-2 hover:bg-gray-100" data-status="berhasil">Berhasil</button>
                        <button class="filter-status w-full text-left px-4 py-2 hover:bg-gray-100" data-status="gagal">Gagal</button>
                        <button class="filter-status w-full text-left px-4 py-2 hover:bg-gray-100" data-status="menunggu">Menunggu</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="riwayat-list">
            @forelse($riwayat as $item)
            <div class="riwayat-card flex items-center bg-gray-50 rounded-lg shadow-sm mb-4 p-4" data-type="{{ $item['type'] }}">
                <div class="flex-shrink-0 mr-4">
                    @if($item['type'] === 'Voucher')
                        <span class="inline-block bg-blue-100 text-blue-600 rounded-full p-3"><i class="fas fa-ticket-alt fa-lg"></i></span>
                    @elseif($item['type'] === 'Sembako')
                        <span class="inline-block bg-green-100 text-green-600 rounded-full p-3"><i class="fas fa-box fa-lg"></i></span>
                    @elseif($item['type'] === 'Transfer')
                        <span class="inline-block bg-yellow-100 text-yellow-600 rounded-full p-3"><i class="fas fa-exchange-alt fa-lg"></i></span>
                    @elseif($item['type'] === 'Setor Sampah')
                        <span class="inline-block bg-orange-100 text-orange-600 rounded-full p-3"><i class="fas fa-truck fa-lg"></i></span>
                    @elseif($item['type'] === 'Donasi')
                        <span class="inline-block bg-purple-100 text-purple-600 rounded-full p-3"><i class="fas fa-hand-holding-heart fa-lg"></i></span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                        <div class="font-bold text-base md:text-lg">{{ $item['type'] === 'Setor Sampah' ? 'Penjemputan Sampah' : ($item['type'] === 'Voucher' ? 'Tukar Poin' : $item['type']) }}</div>
                        <div class="text-xs md:text-sm text-gray-500 mt-1 md:mt-0">Status <span class="font-semibold @if($item['status'] === 'berhasil') text-green-600 @elseif($item['status'] === 'gagal') text-red-600 @else text-yellow-600 @endif">{{ ucfirst($item['status'] ?? 'Selesai') }}</span></div>
                        <div class="text-xs md:text-sm text-gray-500 mt-1 md:mt-0">
                            @if($item['type'] === 'Transfer')
                                Jumlah Poin <span class="font-semibold text-blue-600">- {{ number_format($item['poin']) }} Poin</span>
                            @elseif($item['type'] === 'Setor Sampah')
                                Jumlah Poin <span class="font-semibold text-blue-600">+ {{ number_format($item['poin']) }} Poin</span>
                            @else
                                Jumlah Poin <span class="font-semibold text-blue-600">{{ $item['type'] === 'Voucher' || $item['type'] === 'Sembako' ? '- ' : '+ ' }}{{ number_format($item['poin']) }} Poin</span>
                            @endif
                        </div>
                        <div class="text-xs md:text-sm text-gray-500 mt-1 md:mt-0">Tanggal <span class="font-semibold">{{ \Carbon\Carbon::parse($item['date'])->format('d M Y') }}</span></div>
                        <div class="text-xs md:text-sm text-gray-500 mt-1 md:mt-0">Keterangan <span class="font-semibold">{{ $item['desc'] }}</span></div>
                    </div>
                </div>
                <div class="ml-4">
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-green-700 transition detail-btn" data-detail='@json($item)'>Detail</button>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-400 py-12">
                <i class="fas fa-history text-4xl mb-4"></i>
                <p>Belum ada riwayat transaksi.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Detail -->
    <div id="modal-detail" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden" style="backdrop-filter: blur(4px);">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md text-center relative">
            <button onclick="document.getElementById('modal-detail').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700"><i class="fas fa-times fa-lg"></i></button>
            <div id="modal-content-detail"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Tab filter
const tabs = document.querySelectorAll('.tab-riwayat');
const cards = document.querySelectorAll('.riwayat-card');
tabs.forEach(tab => {
    tab.addEventListener('click', function() {
        tabs.forEach(t => t.classList.remove('border-blue-600', 'text-blue-600'));
        this.classList.add('border-blue-600', 'text-blue-600');
        const type = this.getAttribute('data-type');
        filterCards();
    });
});

// Dropdown filter
const filterBtn = document.getElementById('filterDropdownBtn');
const filterDropdown = document.getElementById('filterDropdown');
let currentStatus = 'Semua';

filterBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    filterDropdown.classList.toggle('hidden');
});

document.addEventListener('click', function() {
    filterDropdown.classList.add('hidden');
});

// Filter status
const filterStatusBtns = document.querySelectorAll('.filter-status');
filterStatusBtns.forEach(btn => {
    btn.addEventListener('click', function() {
        currentStatus = this.getAttribute('data-status');
        filterDropdown.classList.add('hidden');
        filterCards();
    });
});

// Search
const searchInput = document.getElementById('searchRiwayat');
searchInput.addEventListener('input', filterCards);

// Combined filter function
function filterCards() {
    const searchVal = searchInput.value.toLowerCase();
    const activeTab = document.querySelector('.tab-riwayat.border-blue-600').getAttribute('data-type');
    
    cards.forEach(card => {
        const cardType = card.getAttribute('data-type');
        const cardText = card.textContent.toLowerCase();
        const cardStatus = (card.querySelector('.text-xs.md\\:text-sm.text-gray-500.mt-1.md\\:mt-0 .font-semibold')?.textContent || '').toLowerCase();
        
        const matchesSearch = cardText.includes(searchVal);
        const matchesType = activeTab === 'Semua' || cardType === activeTab;
        const matchesStatus = currentStatus === 'Semua' || cardStatus === currentStatus;
        
        card.style.display = (matchesSearch && matchesType && matchesStatus) ? '' : 'none';
    });
}

// Detail modal
const detailBtns = document.querySelectorAll('.detail-btn');
const modal = document.getElementById('modal-detail');
const modalContent = document.getElementById('modal-content-detail');
detailBtns.forEach(btn => {
    btn.addEventListener('click', function() {
        const data = JSON.parse(this.getAttribute('data-detail'));
        
        // Jika tipe transaksi adalah Setor Sampah, arahkan ke halaman riwayat.detail
        if (data.type === 'Setor Sampah') {
            // Arahkan ke halaman detail riwayat dengan ID yang sesuai
            window.location.href = "{{ route('riwayat.detail', ['id' => ':id']) }}".replace(':id', data.id);
            return;
        }
        
        // Untuk tipe transaksi lainnya, tampilkan modal seperti biasa
        let html = `<h3 class='font-bold text-xl mb-2'>${data.type === 'Setor Sampah' ? 'Penjemputan Sampah' : (data.type === 'Voucher' ? 'Tukar Poin' : data.type)}</h3>`;
        html += `<div class='mb-2 text-sm text-gray-500'>Tanggal: <span class='font-semibold'>${new Date(data.date).toLocaleDateString('id-ID')}</span></div>`;
        html += `<div class='mb-2 text-sm text-gray-500'>Status: <span class='font-semibold ${data.status === 'berhasil' ? 'text-green-600' : (data.status === 'gagal' ? 'text-red-600' : 'text-yellow-600')}'>${data.status ? data.status.charAt(0).toUpperCase() + data.status.slice(1) : 'Selesai'}</span></div>`;
        if(data.type === 'Transfer') {
            html += `<div class='mb-2 text-sm text-gray-500'>Poin Ditukar: <span class='font-semibold text-blue-600'>- ${parseInt(data.poin).toLocaleString('id-ID')} Poin</span></div>`;
        } else if(data.type === 'Setor Sampah') {
            html += `<div class='mb-2 text-sm text-gray-500'>Jumlah Poin: <span class='font-semibold text-blue-600'>+ ${parseInt(data.poin).toLocaleString('id-ID')} Poin</span></div>`;
        } else {
            html += `<div class='mb-2 text-sm text-gray-500'>Jumlah Poin: <span class='font-semibold text-blue-600'>${data.type === 'Voucher' || data.type === 'Sembako' ? '- ' : '+ '}${parseInt(data.poin).toLocaleString('id-ID')} Poin</span></div>`;
        }
        html += `<div class='mb-2 text-sm text-gray-500'>Keterangan: <span class='font-semibold'>${data.desc}</span></div>`;
        if(data.kode) {
            html += `<div class='mb-2 text-sm text-gray-500'>Kode Voucher: <span class='bg-gray-100 px-2 py-1 rounded text-xs font-mono'>${data.kode}</span> <button onclick=\"navigator.clipboard.writeText('${data.kode}')\" class='text-gray-400 hover:text-gray-700 ml-1' title='Copy'><i class='fas fa-copy'></i></button></div>`;
        }
        modalContent.innerHTML = html;
        modal.classList.remove('hidden');
    });
});
</script>
@endpush
