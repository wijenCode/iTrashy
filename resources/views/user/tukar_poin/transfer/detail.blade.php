@extends('layouts.app')
@section('page-title', 'Detail Transfer')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-8">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-lg">
        <h2 class="text-xl font-bold mb-6 text-center">Detail Transaksi</h2>
        @if($errors->any())
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="bg-gray-100 rounded-lg p-4 mb-6">
            <table class="w-full text-sm text-gray-700">
                <tbody>
                    @if($jenis === 'bank')
                        <tr><td>Bank</td><td class="text-right">{{ $bank_for_view ?? '-' }}</td></tr>
                        <tr><td>No. Rekening</td><td class="text-right">{{ $nomor_rekening ?? '-' }}</td></tr>
                    @else
                        <tr><td>E-Wallet</td><td class="text-right">{{ $ewallet ?? '-' }}</td></tr>
                        <tr><td>No. Ponsel</td><td class="text-right">{{ $nomor_ponsel ?? '-' }}</td></tr>
                    @endif
                    <tr><td>Jumlah Poin</td><td class="text-right">{{ number_format($jumlah_poin ?? 0, 0, ',', '.') }} Poin</td></tr>
                    <tr><td>Nominal</td><td class="text-right">Rp {{ number_format($nominal ?? 0, 0, ',', '.') }}</td></tr>
                    <tr><td>Biaya Admin</td><td class="text-right">Rp {{ number_format($biaya_admin ?? 0, 0, ',', '.') }}</td></tr>
                    <tr class="font-bold"><td>Total</td><td class="text-right">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</td></tr>
                </tbody>
            </table>
        </div>
        @if($jenis === 'bank')
            <div class="mb-3 text-blue-700 bg-blue-100 border-l-4 border-blue-400 p-2 rounded">
                <strong>Bank yang dipilih:</strong> {{ $bank_for_view ?? '-' }}
            </div>
        @endif
        <div class="flex gap-4 justify-center mt-4">
            <a href="{{ route('transfer.index') }}" class="border border-red-500 text-red-500 px-6 py-2 rounded-lg font-bold hover:bg-red-50 transition">Batal</a>
            <form id="transferForm" action="{{ route('transfer.store') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis_transfer" value="{{ $jenis }}">
                <input type="hidden" name="bank" value="{{ $bank_for_view }}">
                <input type="hidden" name="e_wallet" value="{{ $ewallet }}">
                <input type="hidden" name="nomor_rekening" value="{{ $nomor_rekening }}">
                <input type="hidden" name="nomor_ponsel" value="{{ $nomor_ponsel }}">
                <input type="hidden" name="jumlah_poin" value="{{ $jumlah_poin }}">
                <input type="hidden" name="catatan" value="{{ $catatan }}">
                <button type="submit" id="submitButton" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">Transfer</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('transferForm');
    const submitButton = document.getElementById('submitButton');

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        
        // Disable submit button to prevent double submission
        submitButton.disabled = true;
        submitButton.textContent = 'Memproses...';
        
        // Log form data for debugging
        const formData = new FormData(form);
        console.log('Form data being submitted:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Submit the form
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                // Periksa apakah respons memiliki data JSON (untuk error validasi dari server) atau teks biasa
                return response.text().then(text => { throw new Error(text) });
            }
            return response.json();
        })
        .then(data => {
            console.log('Success:', data);
            // Redirect to index page
            window.location.href = '{{ route('transfer.index') }}';
        })
        .catch(error => {
            console.error('Error:', error);
            // Re-enable submit button
            submitButton.disabled = false;
            submitButton.textContent = 'Transfer';
            // Show error message in an alert
            alert('Terjadi kesalahan saat memproses transfer: ' + error.message);
        });
    });
});
</script>
@endpush 