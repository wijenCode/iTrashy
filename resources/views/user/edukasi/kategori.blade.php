@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <!-- Breadcrumb -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600">
                    <i class="fas fa-home mr-2"></i>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('edukasi.index') }}" class="text-gray-700 hover:text-blue-600">
                        Edukasi
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">{{ ucfirst($kategori) }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ ucfirst($kategori) }}</h1>
        <div class="flex space-x-2">
            @foreach(['artikel', 'video', 'infografis'] as $jenis)
                <a href="{{ route('edukasi.jenis', $jenis) }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium {{ request()->is("edukasi/jenis/$jenis") ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ ucfirst($jenis) }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($edukasi as $konten)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-2xl">
                <a href="{{ route('edukasi.show', $konten->id) }}" class="block">
                    @if($konten->gambar)
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $konten->gambar) }}" 
                                 alt="{{ $konten->judul_konten }}" 
                                 class="w-full h-full object-cover transform transition duration-300 hover:scale-110">
                            <div class="absolute bottom-0 left-0 right-0 px-4 py-2 bg-gradient-to-t from-black to-transparent">
                                <div class="text-white text-sm">
                                    <span class="bg-{{ $konten->jenis_konten == 'video' ? 'red' : 'blue' }}-500 text-white text-xs px-2 py-1 rounded-full">
                                        {{ ucfirst($konten->jenis_konten) }}
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
                                    <i class="fas fa-{{ $konten->jenis_konten == 'video' ? 'video' : 'file-alt' }} text-{{ $konten->jenis_konten == 'video' ? 'red' : 'blue' }}-500 mr-2"></i>
                                    {{ ucfirst($konten->jenis_konten) }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-calendar text-{{ $konten->jenis_konten == 'video' ? 'red' : 'blue' }}-500 mr-2"></i>
                                    {{ \Carbon\Carbon::parse($konten->created_at)->format('d M Y') }}
                                </span>
                            </div>
                            <span class="inline-flex items-center text-{{ $konten->jenis_konten == 'video' ? 'red' : 'blue' }}-500 group">
                                {{ $konten->jenis_konten == 'video' ? 'Tonton' : 'Baca' }}
                                <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition duration-200"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-span-3 text-center py-10">
                <i class="fas fa-folder-open text-gray-400 text-5xl mb-4"></i>
                <p class="text-gray-500">Tidak ada konten untuk kategori ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination if needed -->
    @if($edukasi->hasPages())
        <div class="mt-8">
            {{ $edukasi->links() }}
        </div>
    @endif
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