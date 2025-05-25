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
                        <img class="h-10 w-10" src="{{ asset('storage/images/poin logo.png') }}" alt="Saldo">
                        <div>
                            <p class="text-sm text-gray-800 font-semibold">Poin Terkumpul:</p>
                            <h4 class="text-2xl font-bold text-gray-800">{{ number_format($poin_terkumpul, 0, ',', '.') }}</h4>

                        </div>
                    </div>
                     {{-- Placeholder untuk aksi lain jika ada --}}
                </div>
            </div>

            <div class="p-5 flex flex-col lg:flex-row gap-6">
                <!-- Transfer Lagi / Riwayat Transfer Terbaru -->
                <div class="w-full lg:w-1/3">
                    <h3 class="text-xl font-bold mb-4">Transfer Lagi</h3>
                    <div class="bg-white rounded-lg shadow-md p-4 space-y-4">
                        @forelse($recent_transfer_details as $transfer)
                            <div class="flex items-center space-x-4 p-2 hover:bg-gray-50 rounded-lg cursor-pointer transfer-history-item" 
                                 data-jenis="{{ $transfer->bank ? 'bank' : ($transfer->e_wallet ? 'e_wallet' : '') }}"
                                 data-bank="{{ $transfer->bank }}"
                                 data-ewallet="{{ $transfer->e_wallet }}"
                                 data-rekening="{{ $transfer->nomor_rekening ?? '' }}"
                                 data-ponsel="{{ $transfer->no_telepon ?? '' }}">
                                @if($transfer->bank)
                                    <img class="h-8 w-8" src="{{ asset('storage/images/bank-' . strtolower($transfer->bank) . '.png') }}" alt="Bank {{ $transfer->bank }}">
                                @elseif($transfer->e_wallet)
                                    <img class="h-8 w-8" src="{{ asset('storage/images/e-wallet-' . strtolower($transfer->e_wallet) . '.png') }}" alt="{{ $transfer->e_wallet }}">
                                @endif
                                <div>
                                    <h4 class="font-semibold">{{ $transfer->bank ?? $transfer->e_wallet ?? 'Transfer' }}</h4>
                                    @if($transfer->bank)
                                        <p class="text-sm text-gray-500">{{ $transfer->bank }}</p>
                                    @elseif($transfer->e_wallet)
                                        <p class="text-sm text-gray-500">{{ $transfer->e_wallet }}</p>
                                        <p class="text-sm text-gray-500">{{ $transfer->no_telepon ?? '-' }}</p>
                                    @endif
                                    <p class="text-sm text-gray-500 font-semibold text-blue-600">- {{ number_format($transfer->poin_ditukar ?? 0, 0, ',', '.') }} Poin</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada riwayat transfer terbaru.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Formulir Transfer -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col lg:flex-row gap-8">
                        <div class="flex-1">
                            @unless($hasEnoughPoints)
                                <div class="mb-4 text-center text-red-600 bg-red-100 border-l-4 border-red-400 p-3 rounded">
                                    <p class="font-semibold">Poin Anda belum mencukupi untuk melakukan transfer.</p>
                                    <p class="text-sm">Minimal transfer adalah 25.000 Poin.</p>
                                </div>
                            @endunless
                            <div class="flex mb-4">
                                <button id="bank-tab" class="px-4 py-2 rounded-tl-lg w-1/2 text-center font-semibold bg-[#54B68B] text-white">Bank</button>
                                <button id="ewallet-tab" class="px-4 py-2 rounded-tr-lg w-1/2 text-center font-semibold text-gray-700 bg-gray-200">E-Wallet</button>
                            </div>

                            <!-- Formulir Transfer Bank -->
                            <div id="bank-form">
                                <h4 class="font-semibold mb-3">Bank Tujuan</h4>
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="bank-option p-2 rounded-lg transition-all duration-200 {{ $hasEnoughPoints ? 'cursor-pointer hover:opacity-75' : 'opacity-50 cursor-not-allowed' }}" data-bank="BNI">
                                        <img class="h-10" src="{{ asset('storage/images/bank-bni.png') }}" alt="BNI">
                                    </div>
                                    <div class="bank-option p-2 rounded-lg transition-all duration-200 {{ $hasEnoughPoints ? 'cursor-pointer hover:opacity-75' : 'opacity-50 cursor-not-allowed' }}" data-bank="Mandiri">
                                        <img class="h-10" src="{{ asset('storage/images/bank-mandiri.png') }}" alt="Mandiri">
                                    </div>
                                    <div class="bank-option p-2 rounded-lg transition-all duration-200 {{ $hasEnoughPoints ? 'cursor-pointer hover:opacity-75' : 'opacity-50 cursor-not-allowed' }}" data-bank="BRI">
                                        <img class="h-10" src="{{ asset('storage/images/bank-bri.png') }}" alt="BRI">
                                    </div>
                                    <div class="bank-option p-2 rounded-lg transition-all duration-200 {{ $hasEnoughPoints ? 'cursor-pointer hover:opacity-75' : 'opacity-50 cursor-not-allowed' }}" data-bank="BCA">
                                        <img class="h-10" src="{{ asset('storage/images/bank-bca.png') }}" alt="BCA">
                                    </div>
                                </div>
                                <div class="mb-4 text-blue-700 bg-blue-100 border-l-4 border-blue-400 p-3 rounded">
                                    <strong>Minimal transfer: 25.000 Poin (setara Rp 12.500)</strong>
                                </div>
                                <form action="{{ route('transfer.detail') }}" method="GET">
                                    <input type="hidden" name="jenis" value="bank">
                                    <input type="hidden" name="bank" id="selected_bank" required {{ $hasEnoughPoints ? '' : 'disabled' }}>
                                    <div class="mb-4">
                                        <label for="nomor_rekening" class="block text-sm font-medium text-gray-700">Nomor Rekening</label>
                                        <input type="text" id="nomor_rekening" name="nomor_rekening" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required {{ $hasEnoughPoints ? '' : 'disabled' }}>
                                    </div>
                                    <div class="mb-4">
                                        <label for="jumlah_poin" class="block text-sm font-medium text-gray-700">Jumlah Poin</label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="number" id="jumlah_poin" name="jumlah_poin" class="flex-1 block w-full rounded-md border-gray-300 p-2" min="25000" required {{ $hasEnoughPoints ? '' : 'disabled' }}>
                                        </div>
                                    </div>
                                    <!-- Detail Transfer Kalkulasi -->
                                    <div id="detail-kalkulasi-bank" class="bg-gray-100 rounded-md p-3 mb-4 text-sm">
                                        <p>Poin yang ditukar: <span id="poin-display-bank">0</span></p>
                                        <p>Estimasi Nilai Rupiah: Rp <span id="nominal-display-bank">0</span></p>
                                        <p>Biaya Admin: Rp <span id="admin-display-bank">2.500</span></p>
                                        <p class="font-bold">Total Diproses: Rp <span id="total-display-bank">2.500</span></p>
                                    </div>
                                    <div class="mb-6">
                                        <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                                        <input type="text" id="catatan" name="catatan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" {{ $hasEnoughPoints ? '' : 'disabled' }}>
                                    </div>
                                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md font-bold hover:bg-blue-700 transition {{ $hasEnoughPoints ? '' : 'opacity-50 cursor-not-allowed' }}" {{ $hasEnoughPoints ? '' : 'disabled' }}>Lanjut</button>
                                </form>
                            </div>

                        <!-- Formulir Transfer E-Wallet -->
                        <div id="ewallet-form" class="hidden">
                            <h4 class="font-semibold mb-3">E-Wallet Tujuan</h4>
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="ewallet-option p-2 rounded-lg transition-all duration-200 {{ $hasEnoughPoints ? 'cursor-pointer hover:opacity-75' : 'opacity-50 cursor-not-allowed' }}" data-ewallet="GoPay">
                                    <img class="h-10" src="{{ asset('storage/images/e-wallet-gopay.png') }}" alt="GoPay">
                                </div>
                                <div class="ewallet-option p-2 rounded-lg transition-all duration-200 {{ $hasEnoughPoints ? 'cursor-pointer hover:opacity-75' : 'opacity-50 cursor-not-allowed' }}" data-ewallet="ShopeePay">
                                    <img class="h-10" src="{{ asset('storage/images/e-wallet-shopeepay.png') }}" alt="ShopeePay">
                                </div>
                                <div class="ewallet-option p-2 rounded-lg transition-all duration-200 {{ $hasEnoughPoints ? 'cursor-pointer hover:opacity-75' : 'opacity-50 cursor-not-allowed' }}" data-ewallet="DANA">
                                    <img class="h-10" src="{{ asset('storage/images/e-wallet-dana.png') }}" alt="DANA">
                                </div>
                                <div class="ewallet-option p-2 rounded-lg transition-all duration-200 {{ $hasEnoughPoints ? 'cursor-pointer hover:opacity-75' : 'opacity-50 cursor-not-allowed' }}" data-ewallet="OVO">
                                    <img class="h-10" src="{{ asset('storage/images/e-wallet-ovo.png') }}" alt="OVO">
                                </div>
                            </div>
                            <div class="mb-4 text-yellow-700 bg-yellow-100 border-l-4 border-yellow-400 p-3 rounded">
                                <strong>Minimal transfer: 25.000 Poin (setara Rp 12.500)</strong>
                            </div>
                            <form action="{{ route('transfer.detail') }}" method="GET">
                                <input type="hidden" name="jenis" value="e_wallet">
                                <input type="hidden" name="e_wallet" id="selected_ewallet" required {{ $hasEnoughPoints ? '' : 'disabled' }}>
                                <div class="mb-4">
                                    <label for="nomor_ponsel" class="block text-sm font-medium text-gray-700">Nomor Ponsel</label>
                                    <input type="text" id="nomor_ponsel" name="nomor_ponsel" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required {{ $hasEnoughPoints ? '' : 'disabled' }}>
                                </div>
                                <div class="mb-4">
                                    <label for="jumlah_poin_ewallet" class="block text-sm font-medium text-gray-700">Jumlah Poin</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="number" id="jumlah_poin_ewallet" name="jumlah_poin" class="flex-1 block w-full rounded-md border-gray-300 p-2" min="25000" required {{ $hasEnoughPoints ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                <!-- Detail Transfer Kalkulasi -->
                                <div id="detail-kalkulasi-ewallet" class="bg-gray-100 rounded-md p-3 mb-4 text-sm">
                                    <p>Poin yang ditukar: <span id="poin-display-ewallet">0</span></p>
                                    <p>Estimasi Nilai Rupiah: Rp <span id="nominal-display-ewallet">0</span></p>
                                    <p>Biaya Admin: Rp <span id="admin-display-ewallet">1.000</span></p>
                                    <p class="font-bold">Total Diproses: Rp <span id="total-display-ewallet">1.000</span></p>
                                </div>
                                <div class="mb-6">
                                    <label for="catatan_ewallet" class="block text-sm font-medium text-gray-700">Catatan</label>
                                    <input type="text" id="catatan_ewallet" name="catatan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" {{ $hasEnoughPoints ? '' : 'disabled' }}>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md font-bold hover:bg-blue-700 transition {{ $hasEnoughPoints ? '' : 'opacity-50 cursor-not-allowed' }}" {{ $hasEnoughPoints ? '' : 'disabled' }}>Lanjut</button>
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
            document.querySelector('input[name="nomor_rekening"]').value = data.rekening;
            // Set bank yang dipilih
            const bankOption = document.querySelector(`.bank-option[data-bank="${data.bank}"]`);
            if (bankOption) {
                selectBank(bankOption);
            }
        }

        // Fungsi untuk mengisi form e-wallet
        function fillEwalletForm(data) {
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
            // Set nilai bank yang dipilih di input hidden yang ada di dalam form
            // Menggunakan form bank yang aktif saat ini untuk mencari input #selected_bank
            const activeBankForm = document.querySelector('#bank-form form:not(.hidden)') || document.querySelector('#bank-form form');
             if (activeBankForm) {
                const selectedBankInput = activeBankForm.querySelector('#selected_bank');
                 if (selectedBankInput) {
                     selectedBankInput.value = bankOption.dataset.bank;
                 }
             }
        }

        // Fungsi untuk memilih e-wallet
        function selectEwallet(ewalletOption) {
            // Hapus kelas active dari semua e-wallet
            document.querySelectorAll('.ewallet-option').forEach(opt => {
                opt.classList.remove('bg-blue-100', 'ring-2', 'ring-blue-500');
            });
            // Tambah kelas active ke e-wallet yang dipilih
            ewalletOption.classList.add('bg-blue-100', 'ring-2', 'ring-blue-500');
            // Set nilai e-wallet yang dipilih di input hidden yang ada di dalam form
             // Menggunakan form e-wallet yang aktif saat ini untuk mencari input #selected_ewallet
            const activeEwalletForm = document.querySelector('#ewallet-form form:not(.hidden)') || document.querySelector('#ewallet-form form');
             if (activeEwalletForm) {
                 const selectedEwalletInput = activeEwalletForm.querySelector('#selected_ewallet');
                 if (selectedEwalletInput) {
                     selectedEwalletInput.value = ewalletOption.dataset.ewallet;
                 }
             }
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

        // Tambahkan script untuk update detail transfer
        function updateDetailTransfer() {
            let jenis = document.querySelector('#bank-form') && !document.querySelector('#bank-form').classList.contains('hidden') ? 'bank' : 'e_wallet';
            let jumlah_poin = 0;
            let biaya_admin = 0;
            let detail_kalkulasi_id = '';
            let poin_display_id = '';
            let nominal_display_id = '';
            let admin_display_id = '';
            let total_display_id = '';

            if (jenis === 'bank') {
                jumlah_poin = parseInt(document.getElementById('jumlah_poin')?.value || 0);
                biaya_admin = 2500;
                detail_kalkulasi_id = 'detail-kalkulasi-bank';
                poin_display_id = 'poin-display-bank';
                nominal_display_id = 'nominal-display-bank';
                admin_display_id = 'admin-display-bank';
                total_display_id = 'total-display-bank';
            } else {
                jumlah_poin = parseInt(document.getElementById('jumlah_poin_ewallet')?.value || 0);
                biaya_admin = 1000;
                detail_kalkulasi_id = 'detail-kalkulasi-ewallet';
                poin_display_id = 'poin-display-ewallet';
                nominal_display_id = 'nominal-display-ewallet';
                admin_display_id = 'admin-display-ewallet';
                total_display_id = 'total-display-ewallet';
            }

            let estimasi_rupiah = jumlah_poin * 0.50;
            let total_diproses = estimasi_rupiah + biaya_admin;

            // Update display
            document.getElementById(poin_display_id).innerText = jumlah_poin.toLocaleString('id-ID');
            document.getElementById(nominal_display_id).innerText = estimasi_rupiah.toLocaleString('id-ID');
            document.getElementById(admin_display_id).innerText = biaya_admin.toLocaleString('id-ID');
            document.getElementById(total_display_id).innerText = total_diproses.toLocaleString('id-ID');

             // Update hidden nominal input for form submission
             if (jenis === 'bank') {
                 document.querySelector('#bank-form input[name="nominal"]').value = estimasi_rupiah;
             } else {
                 document.querySelector('#ewallet-form input[name="nominal"]').value = estimasi_rupiah;
             }
        }
        // Event listeners untuk update detail
        ['input','change'].forEach(evt => {
            document.querySelectorAll('#jumlah_poin, #jumlah_poin_ewallet, #selected_bank, #selected_ewallet').forEach(el => {
                if(el) el.addEventListener(evt, updateDetailTransfer);
            });
        });
        document.getElementById('bank-tab').addEventListener('click', updateDetailTransfer);
        document.getElementById('ewallet-tab').addEventListener('click', updateDetailTransfer);
        // Inisialisasi detail pertama kali
        updateDetailTransfer();

        // Tambahkan JS agar hidden input bank/ewallet terisi saat memilih opsi
        function syncHiddenInputs() {
            // Fungsi ini tidak lagi diperlukan untuk sinkronisasi ke form_bank/ewallet
            // karena input #selected_bank dan #selected_ewallet sudah di dalam form
        }
        document.querySelectorAll('.bank-option, .ewallet-option').forEach(opt => {
            opt.addEventListener('click', function() {
                // Memanggil selectBank/Ewallet untuk menandai pilihan dan mengisi input hidden yang ada di form
                if (this.dataset.bank) {
                    selectBank(this);
                } else if (this.dataset.ewallet) {
                    selectEwallet(this);
                }
                // Tidak perlu memanggil syncHiddenInputs lagi
            });
        });
        // Event listener untuk perubahan pada input hidden #selected_bank dan #selected_ewallet
        // Tidak lagi perlu memanggil syncHiddenInputs
        document.getElementById('selected_bank').addEventListener('change', function() { /* console.log('#selected_bank changed', this.value); */ });
        document.getElementById('selected_ewallet').addEventListener('change', function() { /* console.log('#selected_ewallet changed', this.value); */ });

        // Event listener submit form (fallback sinkronisasi dihapus)
        // document.querySelectorAll('#bank-form form, #ewallet-form form').forEach(form => {
        //     form.addEventListener('submit', function(e) {
        //         // syncHiddenInputs(); // Tidak perlu lagi
        //     });
        // });
    });
</script>
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showNotification({
                title: 'Transfer Berhasil',
                message: '{{ session('success') }}',
                type: 'success',
                link: '{{ route('riwayat.index') }}'
            });
        });
    </script>
@endif
@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showNotification({
                title: 'Poin Tidak Cukup',
                message: '{{ session('error') }}',
                type: 'error',
                icon: 'fa-solid fa-coins',
            });
        });
    </script>
@endif
@endpush
