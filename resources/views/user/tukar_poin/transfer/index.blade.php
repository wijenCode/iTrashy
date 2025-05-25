@extends('layouts.app')

@section('page-title', 'Transfer Poin')

@section('content')
    <div class="flex-1 flex flex-col min-h-screen lg:ml-0">
        <div class="flex-1 overflow-y-auto">
            <!-- Kartu Saldo -->
            <div class="p-5">
                <div class="lg:flex justify-between lg:justify-around lg:space-x-52 lg:space-y-0 space-y-8 bg-gradient-to-r from-[#FED4B4] to-[#54B68B] p-4 rounded-lg">
                    <div class="flex items-center justify-center space-x-4">
                         {{-- Placeholder untuk tampilan saldo --}}
                        <img class="h-10 w-10" src="{{ asset('storage/images/wallet.png') }}" alt="Saldo">
                        <h4 class="text-2xl font-bold">Rp {{ number_format($poin_terkumpul * 1000, 0, ',', '.') }}</h4> {{-- Asumsi 1 poin = Rp 1000 untuk tampilan --}}
                    </div>
                     {{-- Placeholder untuk aksi lain jika ada --}}
                </div>
            </div>

            <div class="p-5 flex flex-col lg:flex-row gap-6">
                <!-- Transfer Lagi / Riwayat Transfer Terbaru -->
                <div class="w-full lg:w-1/3">
                    <h3 class="text-xl font-bold mb-4">Transfer Lagi</h3>
                    <div class="bg-white rounded-lg shadow-md p-4 space-y-4">
                        @forelse($riwayat_transfer as $transfer)
                            <div class="flex items-center space-x-4 p-2 hover:bg-gray-50 rounded-lg cursor-pointer transfer-history-item" 
                                 data-jenis="{{ $transfer->jenis_transfer }}"
                                 data-nama="{{ $transfer->nama_penerima }}"
                                 data-bank="{{ $transfer->bank }}"
                                 data-ewallet="{{ $transfer->e_wallet }}"
                                 data-rekening="{{ $transfer->nomor_rekening }}"
                                 data-ponsel="{{ $transfer->nomor_ponsel }}">
                                @if($transfer->jenis_transfer == 'bank')
                                    <img class="h-8 w-8" src="{{ asset('storage/images/bank-' . strtolower($transfer->bank) . '.png') }}" alt="Bank {{ $transfer->bank }}">
                                @else
                                    <img class="h-8 w-8" src="{{ asset('storage/images/e-wallet-' . strtolower($transfer->e_wallet) . '.png') }}" alt="{{ $transfer->e_wallet }}">
                                @endif
                                <div>
                                    <h4 class="font-semibold">{{ $transfer->nama_penerima }}</h4>
                                    @if($transfer->jenis_transfer == 'bank')
                                        <p class="text-sm text-gray-500">{{ $transfer->bank }}</p>
                                        <p class="text-sm text-gray-500">{{ $transfer->nomor_rekening }}</p>
                                    @else
                                        <p class="text-sm text-gray-500">{{ $transfer->e_wallet }}</p>
                                        <p class="text-sm text-gray-500">{{ $transfer->nomor_ponsel }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada riwayat transfer terbaru.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Formulir Transfer -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex mb-4">
                            <button id="bank-tab" class="px-4 py-2 rounded-tl-lg w-1/2 text-center font-semibold bg-[#54B68B] text-white">Bank</button>
                            <button id="ewallet-tab" class="px-4 py-2 rounded-tr-lg w-1/2 text-center font-semibold text-gray-700 bg-gray-200">E-Wallet</button>
                        </div>

                        <!-- Formulir Transfer Bank -->
                        <div id="bank-form">
                            <h4 class="font-semibold mb-3">Bank Tujuan</h4>
                            <div class="flex items-center space-x-4 mb-4">
                                <input type="hidden" name="bank" id="selected_bank" required>
                                <div class="bank-option p-2 rounded-lg transition-all duration-200" data-bank="BNI">
                                    <img class="h-10 cursor-pointer hover:opacity-75 transition" src="{{ asset('storage/images/bank-bni.png') }}" alt="BNI">
                                </div>
                                <div class="bank-option p-2 rounded-lg transition-all duration-200" data-bank="Mandiri">
                                    <img class="h-10 cursor-pointer hover:opacity-75 transition" src="{{ asset('storage/images/bank-mandiri.png') }}" alt="Mandiri">
                                </div>
                                <div class="bank-option p-2 rounded-lg transition-all duration-200" data-bank="BRI">
                                    <img class="h-10 cursor-pointer hover:opacity-75 transition" src="{{ asset('storage/images/bank-bri.png') }}" alt="BRI">
                                </div>
                                <div class="bank-option p-2 rounded-lg transition-all duration-200" data-bank="BCA">
                                    <img class="h-10 cursor-pointer hover:opacity-75 transition" src="{{ asset('storage/images/bank-bca.png') }}" alt="BCA">
                                </div>
                            </div>
                            <form action="{{ route('transfer.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="jenis_transfer" value="bank">
                                <div class="mb-4">
                                    <label for="nama_penerima" class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                                    <input type="text" id="nama_penerima" name="nama_penerima" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                                </div>
                                <div class="mb-4">
                                    <label for="nomor_rekening" class="block text-sm font-medium text-gray-700">Nomor Rekening</label>
                                    <input type="text" id="nomor_rekening" name="nomor_rekening" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                                </div>
                                <div class="mb-4">
                                    <label for="jumlah_transfer" class="block text-sm font-medium text-gray-700">Nominal</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">Rp</span>
                                        <input type="number" id="jumlah_transfer" name="jumlah_transfer" class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 p-2" min="10000" required>
                                    </div>
                                </div>
                                <div class="mb-4 text-gray-600 text-sm">
                                    Tambahan Biaya Admin Rp 2.500
                                </div>
                                <div class="mb-6">
                                    <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                                    <input type="text" id="catatan" name="catatan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                </div>
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md font-bold hover:bg-blue-700 transition">Lanjut</button>
                            </form>
                        </div>

                        <!-- Formulir Transfer E-Wallet -->
                        <div id="ewallet-form" class="hidden">
                            <h4 class="font-semibold mb-3">E-Wallet Tujuan</h4>
                            <div class="flex items-center space-x-4 mb-4">
                                <input type="hidden" name="e_wallet" id="selected_ewallet" required>
                                <div class="ewallet-option p-2 rounded-lg transition-all duration-200" data-ewallet="GoPay">
                                    <img class="h-10 cursor-pointer hover:opacity-75 transition" src="{{ asset('storage/images/e-wallet-gopay.png') }}" alt="GoPay">
                                </div>
                                <div class="ewallet-option p-2 rounded-lg transition-all duration-200" data-ewallet="ShopeePay">
                                    <img class="h-10 cursor-pointer hover:opacity-75 transition" src="{{ asset('storage/images/e-wallet-shopeepay.png') }}" alt="ShopeePay">
                                </div>
                                <div class="ewallet-option p-2 rounded-lg transition-all duration-200" data-ewallet="DANA">
                                    <img class="h-10 cursor-pointer hover:opacity-75 transition" src="{{ asset('storage/images/e-wallet-dana.png') }}" alt="DANA">
                                </div>
                                <div class="ewallet-option p-2 rounded-lg transition-all duration-200" data-ewallet="OVO">
                                    <img class="h-10 cursor-pointer hover:opacity-75 transition" src="{{ asset('storage/images/e-wallet-ovo.png') }}" alt="OVO">
                                </div>
                            </div>
                            <form action="{{ route('transfer.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="jenis_transfer" value="e_wallet">
                                <div class="mb-4">
                                    <label for="nama_penerima_ewallet" class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                                    <input type="text" id="nama_penerima_ewallet" name="nama_penerima" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                                </div>
                                <div class="mb-4">
                                    <label for="nomor_ponsel" class="block text-sm font-medium text-gray-700">Nomor Ponsel</label>
                                    <input type="text" id="nomor_ponsel" name="nomor_ponsel" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                                </div>
                                <div class="mb-4">
                                    <label for="jumlah_transfer_ewallet" class="block text-sm font-medium text-gray-700">Nominal</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">Rp</span>
                                        <input type="number" id="jumlah_transfer_ewallet" name="jumlah_transfer" class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 p-2" min="10000" required>
                                    </div>
                                </div>
                                <div class="mb-4 text-gray-600 text-sm">
                                    Tambahan Biaya Admin Rp 2.500
                                </div>
                                <div class="mb-6">
                                    <label for="catatan_ewallet" class="block text-sm font-medium text-gray-700">Catatan</label>
                                    <input type="text" id="catatan_ewallet" name="catatan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                </div>
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md font-bold hover:bg-blue-700 transition">Lanjut</button>
                            </form>
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
        const bankTab = document.getElementById('bank-tab');
        const ewalletTab = document.getElementById('ewallet-tab');
        const bankForm = document.getElementById('bank-form');
        const ewalletForm = document.getElementById('ewallet-form');
        const selectedBankInput = document.getElementById('selected_bank');
        const selectedEwalletInput = document.getElementById('selected_ewallet');

        // Fungsi untuk mengisi form bank
        function fillBankForm(data) {
            document.querySelector('input[name="nama_penerima"]').value = data.nama;
            document.querySelector('input[name="nomor_rekening"]').value = data.rekening;
            // Set bank yang dipilih
            const bankOption = document.querySelector(`.bank-option[data-bank="${data.bank}"]`);
            if (bankOption) {
                selectBank(bankOption);
            }
        }

        // Fungsi untuk mengisi form e-wallet
        function fillEwalletForm(data) {
            document.querySelector('input[name="nama_penerima"]').value = data.nama;
            document.querySelector('input[name="nomor_ponsel"]').value = data.ponsel;
            // Set e-wallet yang dipilih
            const ewalletOption = document.querySelector(`.ewallet-option[data-ewallet="${data.ewallet}"]`);
            if (ewalletOption) {
                selectEwallet(ewalletOption);
            }
        }

        // Fungsi untuk memilih bank
        function selectBank(bankOption) {
            // Hapus kelas active dari semua bank
            document.querySelectorAll('.bank-option').forEach(opt => {
                opt.classList.remove('bg-blue-100', 'ring-2', 'ring-blue-500');
            });
            // Tambah kelas active ke bank yang dipilih
            bankOption.classList.add('bg-blue-100', 'ring-2', 'ring-blue-500');
            // Set nilai bank yang dipilih
            selectedBankInput.value = bankOption.dataset.bank;
        }

        // Fungsi untuk memilih e-wallet
        function selectEwallet(ewalletOption) {
            // Hapus kelas active dari semua e-wallet
            document.querySelectorAll('.ewallet-option').forEach(opt => {
                opt.classList.remove('bg-blue-100', 'ring-2', 'ring-blue-500');
            });
            // Tambah kelas active ke e-wallet yang dipilih
            ewalletOption.classList.add('bg-blue-100', 'ring-2', 'ring-blue-500');
            // Set nilai e-wallet yang dipilih
            selectedEwalletInput.value = ewalletOption.dataset.ewallet;
        }

        // Event listener untuk klik pada bank
        document.querySelectorAll('.bank-option').forEach(option => {
            option.addEventListener('click', function() {
                selectBank(this);
            });
        });

        // Event listener untuk klik pada e-wallet
        document.querySelectorAll('.ewallet-option').forEach(option => {
            option.addEventListener('click', function() {
                selectEwallet(this);
            });
        });

        // Event listener untuk klik pada riwayat transfer
        document.querySelectorAll('.transfer-history-item').forEach(item => {
            item.addEventListener('click', function() {
                const data = {
                    jenis: this.dataset.jenis,
                    nama: this.dataset.nama,
                    bank: this.dataset.bank,
                    ewallet: this.dataset.ewallet,
                    rekening: this.dataset.rekening,
                    ponsel: this.dataset.ponsel
                };

                if (data.jenis === 'bank') {
                    bankTab.click();
                    fillBankForm(data);
                } else {
                    ewalletTab.click();
                    fillEwalletForm(data);
                }
            });
        });

        bankTab.addEventListener('click', function() {
            bankTab.classList.add('bg-[#54B68B]', 'text-white');
            bankTab.classList.remove('bg-gray-200', 'text-gray-700');
            ewalletTab.classList.remove('bg-[#54B68B]', 'text-white');
            ewalletTab.classList.add('bg-gray-200', 'text-gray-700');
            bankForm.classList.remove('hidden');
            ewalletForm.classList.add('hidden');
        });

        ewalletTab.addEventListener('click', function() {
            ewalletTab.classList.add('bg-[#54B68B]', 'text-white');
            ewalletTab.classList.remove('bg-gray-200', 'text-gray-700');
            bankTab.classList.remove('bg-[#54B68B]', 'text-white');
            bankTab.classList.add('bg-gray-200', 'text-gray-700');
            ewalletForm.classList.remove('hidden');
            bankForm.classList.add('hidden');
        });

        // Status awal: tampilkan formulir bank
        bankTab.click();
    });
</script>
@endpush
