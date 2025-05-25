@extends('layouts.app')
@section('page-title', 'Edukasi') <!-- Menetapkan judul halaman Edukasi -->
@section('content')
    <div class="p-5">   
        
        <!-- Banner Section -->
        <div class="text-center p-6 mb-6 rounded-lg ">
            <img src="{{ asset('storage/images/poster2.png') }}" alt="Banner Edukasi" class="w-full h-auto rounded-lg mb-4 shadow-xl">
        </div>

        <!-- Artikel Section -->    
        <div class="space-y-5">
            <div class="flex items-center justify-between">
                <h4 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-newspaper mr-3 text-blue-500"></i>
                    Artikel
                </h4>
                <a href="{{ route('edukasi.kategori', 'artikel') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                    Lihat Semua
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            <div class="overflow-x-auto max-w-full">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($edukasi->where('jenis_konten', 'artikel') as $konten)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-2xl">
                            <a href="{{ route('edukasi.show', $konten->id) }}" class="block">
                                @if($konten->gambar)
                                    <div class="relative h-48 overflow-hidden">
                                        <img src="{{ asset('storage/' . $konten->gambar) }}" 
                                             alt="{{ $konten->judul_konten }}" 
                                             class="w-full h-full object-cover transform transition duration-300 hover:scale-110">
                                        <div class="absolute bottom-0 left-0 right-0 px-4 py-2 bg-gradient-to-t from-black to-transparent">
                                            <div class="text-white text-sm">
                                                <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                                                    {{ ucfirst($konten->kategori) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="p-5">
                                    <h4 class="font-bold text-lg mb-3 text-gray-800 line-clamp-2 hover:text-blue-600 transition duration-200">
                                        {{ $konten->judul_konten }}
                                    </h4>
                                    <div class="flex items-center justify-between text-sm text-gray-600">
                                        <div class="flex items-center space-x-4">
                                            <span class="flex items-center">
                                                <i class="fas fa-folder text-blue-500 mr-2"></i>
                                                {{ ucfirst($konten->jenis_konten) }}
                                            </span>
                                            <span class="flex items-center">
                                                <i class="fas fa-calendar text-blue-500 mr-2"></i>
                                                {{ \Carbon\Carbon::parse($konten->created_at)->format('d M Y') }}
                                            </span>
                                        </div>
                                        <span class="inline-flex items-center text-blue-500 group">
                                            Baca
                                            <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition duration-200"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Video Section -->
        <div class="space-y-5 mt-10">
            <div class="flex items-center justify-between">
                <h4 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-video mr-3 text-red-500"></i>
                    Video
                </h4>
                <a href="{{ route('edukasi.kategori', 'video') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                    Lihat Semua
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            <div class="overflow-x-auto max-w-full">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($edukasi->where('jenis_konten', 'video') as $konten)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-2xl">
                            <a href="{{ route('edukasi.show', $konten->id) }}" class="block">
                                @if($konten->gambar)
                                    <div class="relative h-48 group overflow-hidden">
                                        <img src="{{ asset('storage/' . $konten->gambar) }}" 
                                             alt="{{ $konten->judul_konten }}" 
                                             class="w-full h-full object-cover transform transition duration-300 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                            <i class="fas fa-play-circle text-white text-5xl transform group-hover:scale-110 transition duration-300"></i>
                                        </div>
                                        <div class="absolute bottom-0 left-0 right-0 px-4 py-2 bg-gradient-to-t from-black to-transparent">
                                            <div class="text-white text-sm">
                                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                                    {{ ucfirst($konten->kategori) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="relative h-48 bg-gray-200 flex items-center justify-center group">
                                        <i class="fas fa-video text-gray-400 text-4xl group-hover:text-blue-500 transition duration-300"></i>
                                    </div>
                                @endif
                                <div class="p-5">
                                    <h4 class="font-bold text-lg mb-3 text-gray-800 line-clamp-2 hover:text-blue-600 transition duration-200">
                                        {{ $konten->judul_konten }}
                                    </h4>
                                    <div class="flex items-center justify-between text-sm text-gray-600">
                                        <div class="flex items-center space-x-4">
                                            <span class="flex items-center">
                                                <i class="fas fa-video text-red-500 mr-2"></i>
                                                {{ ucfirst($konten->jenis_konten) }}
                                            </span>
                                            <span class="flex items-center">
                                                <i class="fas fa-calendar text-red-500 mr-2"></i>
                                                {{ \Carbon\Carbon::parse($konten->created_at)->format('d M Y') }}
                                            </span>
                                        </div>
                                        <span class="inline-flex items-center text-red-500 group">
                                            Tonton
                                            <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition duration-200"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Custom hover animations */
    .group:hover .group-hover\:translate-x-1 {
        transform: translateX(0.25rem);
    }
    
    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }
    
    /* Gradient overlay */
    .from-black {
        background-image: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%);
    }
    
    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
</style>
@endpush