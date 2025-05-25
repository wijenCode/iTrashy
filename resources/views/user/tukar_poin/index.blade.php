@extends('layouts.app')

@section('page-title', 'Tukar Poin')

@section('content')
        <div class="flex-1 flex flex-col min-h-screen lg:ml-0">
            <div class="flex-1 overflow-y-auto">
                <!-- Balance Card -->
                <div class="p-5">
                    <div class="lg:flex justify-between lg:justify-around lg:space-x-52 lg:space-y-0 space-y-8 bg-gradient-to-r from-[#FED4B4] to-[#54B68B] p-4 rounded-lg">
                        <div class="flex items-center justify-center space-x-4">
                            <img class="h-10 w-10" src="{{ asset('storage/images/poin logo.png') }}" alt="Poin">
                            <h4 class="text-2xl font-bold">Poin Anda : {{ number_format($poin_terkumpul) }}</h4>  
                        </div>
                        <div class="flex justify-between lg:justify-end pl-5 pr-5 lg:pr-0 lg:pl-0 lg:space-x-20">
                            <a href="{{ route('transfer.index') }}">
                                <div class="flex flex-col items-center">
                                    <button class="bg-white rounded-xl w-12 h-12 flex items-center justify-center shadow hover:bg-gray-50 transition-colors">
                                        <img src="{{ asset('storage/images/transfer.png') }}" alt="Transfer" class="w-6 h-6">
                                    </button>
                                    <span class="text-sm mt-2 text-center">Transfer</span>
                                </div>
                            </a>

                            <a href="{{ route('donasi.index') }}">
                                <div class="flex flex-col items-center">
                                    <button class="bg-white rounded-xl w-12 h-12 flex items-center justify-center shadow hover:bg-gray-50 transition-colors">
                                        <img src="{{ asset('storage/images/donasi.png') }}" alt="Donasi" class="w-6 h-6">
                                    </button>
                                    <span class="text-sm mt-2 text-center">Donasi</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter -->
                <div class="flex p-5 space-x-4">
                    <button id="sembako-btn" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full">Sembako</button>
                    <button id="voucher-btn" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-full">Voucher</button>
                </div>

                <!-- Voucher dan Sembako -->
                <div class="p-5 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-2 lg:gap-5">
                    @foreach ($vouchers as $voucher)
                        <a href="{{ route('voucher.detail', $voucher->id) }}" class="voucher-card">
                            <div class="bg-white rounded-lg shadow-md p-3">
                                <img src="{{ asset('assets/image/' . $voucher->gambar) }}" alt="Voucher Image" class="w-full h-32 md:h-40 object-cover rounded-lg">
                                <h4 class="font-semibold mt-2">{{ $voucher->nama_voucher }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $voucher->deskripsi }}</p>
                                <div class="flex justify-between items-center mt-2">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ asset('storage/images/poin logo.png') }}" alt="poin" class="h-8 w-8">
                                        <div class="hidden sm:block"><p>Trash Poin</p></div>
                                    </div>
                                    <span class="text-blue-600 font-bold">{{ $voucher->poin }} Poin</span>
                                </div>
                            </div>
                        </a>
                    @endforeach

                    @foreach ($sembakos as $sembako)
                        <a href="{{ route('sembako.detail', $sembako->id) }}" class="sembako-card">
                            <div class="bg-white rounded-lg shadow-md p-3">
                                <img src="{{ asset('assets/image/' . $sembako->gambar) }}" alt="Sembako Image" class="w-full h-32 md:h-40 object-cover rounded-lg">
                                <h4 class="font-semibold mt-2">{{ $sembako->nama_sembako }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $sembako->deskripsi }}</p>
                                <div class="flex justify-between items-center mt-2">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ asset('storage/images/poin logo.png') }}" alt="poin" class="h-8 w-8">
                                        <div class="hidden sm:block"><p>Trash Poin</p></div>
                                    </div>
                                    <span class="text-blue-600 font-bold">{{ $sembako->poin }} Poin</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sembakoBtn = document.getElementById('sembako-btn');
        const voucherBtn = document.getElementById('voucher-btn');
        const voucherCards = document.querySelectorAll('.voucher-card');
        const sembakoCards = document.querySelectorAll('.sembako-card');

        function showVoucher() {
            voucherCards.forEach(card => card.style.display = 'block');
            sembakoCards.forEach(card => card.style.display = 'none');
            voucherBtn.classList.add('bg-blue-500', 'text-white');
            sembakoBtn.classList.remove('bg-blue-500', 'text-white');
        }
        function showSembako() {
            voucherCards.forEach(card => card.style.display = 'none');
            sembakoCards.forEach(card => card.style.display = 'block');
            sembakoBtn.classList.add('bg-blue-500', 'text-white');
            voucherBtn.classList.remove('bg-blue-500', 'text-white');
        }
        // Default: tampilkan semua
        voucherBtn.addEventListener('click', showVoucher);
        sembakoBtn.addEventListener('click', showSembako);
        // Tampilkan semua di awal
        voucherCards.forEach(card => card.style.display = 'block');
        sembakoCards.forEach(card => card.style.display = 'block');
    });
</script>
@endpush
@endsection
