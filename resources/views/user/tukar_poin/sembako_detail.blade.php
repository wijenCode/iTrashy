@extends('layouts.app')
@section('page-title', 'Detail Sembako')
@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col lg:flex-row gap-6 p-6">
    <!-- Kartu Utama -->
    <div class="flex-1 max-w-xl mx-auto lg:mx-0">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center mb-4">
                <div class="bg-blue-500 text-white px-4 py-2 rounded-tl-lg rounded-br-lg font-bold text-lg flex items-center">
                    <img src="{{ asset('assets/icon/poin logo.png') }}" class="w-6 h-6 mr-2"> Trash Poin <span class="ml-2">{{ number_format($sembako->poin) }}</span>
                </div>
            </div>
            <img src="{{ asset('assets/image/' . $sembako->gambar) }}" alt="Sembako Image" class="w-full h-40 object-cover rounded-lg mb-4">
            <h2 class="text-xl font-bold mb-2">{{ $sembako->nama_sembako }}</h2>
            <p class="text-gray-600 mb-4">{{ $sembako->deskripsi }}</p>
            <div class="bg-gray-100 rounded-lg p-4 mb-4">
                <h4 class="font-semibold mb-2">Rincian Penukaran</h4>
                <ul class="text-sm text-gray-700 list-disc pl-5 space-y-1">
                    @foreach($sembako->rincian as $rincian)
                        <li>{{ $rincian }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="flex justify-between items-center mb-4">
                <span class="font-bold text-lg">Trash Poin</span>
                <span class="font-bold text-blue-600 text-lg">{{ number_format($sembako->poin) }}</span>
            </div>
            <form action="{{ route('sembako.tukar', $sembako->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700 transition">Tukar</button>
            </form>
        </div>
    </div>
    <!-- Sembako Lainnya -->
    <div class="flex-1 max-w-md mx-auto lg:mx-0">
        <h3 class="text-xl font-bold mb-4">Sembako lainnya</h3>
        <div class="space-y-4">
            @foreach($sembakos as $item)
                @if($item->id != $sembako->id)
                <a href="{{ route('sembako.detail', $item->id) }}" class="block bg-white rounded-lg shadow-md p-4 hover:bg-blue-50 transition">
                    <div class="flex items-center mb-2">
                        <div class="bg-blue-500 text-white px-3 py-1 rounded-tl-lg rounded-br-lg font-bold text-sm flex items-center">
                            <img src="{{ asset('assets/icon/poin logo.png') }}" class="w-4 h-4 mr-1"> Trash Poin <span class="ml-1">{{ number_format($item->poin) }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('assets/image/' . $item->gambar) }}" alt="Sembako Image" class="w-16 h-12 object-cover rounded-lg">
                        <div>
                            <h4 class="font-semibold">{{ $item->nama_sembako }}</h4>
                            <p class="text-xs text-gray-500 line-clamp-2">{{ $item->deskripsi }}</p>
                        </div>
                    </div>
                </a>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection

@if(session('tukar_status'))
    <div id="modal-tukar" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70" style="backdrop-filter: blur(4px);">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-sm text-center relative">
            <div class="flex flex-col items-center">
                <div class="bg-blue-100 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" /></svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Penukaran {{ session('tukar_status.success') ? 'Berhasil!' : 'Gagal!' }}</h3>
                <p class="text-gray-700 mb-4">{{ session('tukar_status.message') }}</p>
                <button onclick="document.getElementById('modal-tukar').style.display='none'" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700 transition">Tutup</button>
            </div>
        </div>
    </div>
@endif 