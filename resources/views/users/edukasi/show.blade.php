<!-- resources/views/edukasi/show.blade.php -->

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
                    <span class="text-gray-500">{{ $edukasi->judul_konten }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <!-- Header -->
            <div class="mb-8 border-b pb-6">
                <h1 class="text-4xl font-bold text-gray-800 mb-4 leading-tight">{{ $edukasi->judul_konten }}</h1>
                <div class="flex flex-wrap items-center text-sm text-gray-600 gap-6">
                    <span class="flex items-center px-3 py-1 bg-gray-100 rounded-full">
                        <i class="fas fa-folder mr-2 text-blue-500"></i>
                        {{ ucfirst($edukasi->kategori) }}
                    </span>
                    <span class="flex items-center px-3 py-1 bg-gray-100 rounded-full">
                        <i class="fas fa-{{ $edukasi->jenis_konten == 'video' ? 'video' : 'file-alt' }} mr-2 text-{{ $edukasi->jenis_konten == 'video' ? 'red' : 'blue' }}-500"></i>
                        {{ ucfirst($edukasi->jenis_konten) }}
                    </span>
                    <span class="flex items-center px-3 py-1 bg-gray-100 rounded-full">
                        <i class="fas fa-calendar mr-2 text-green-500"></i>
                        {{ $edukasi->created_at->format('d M Y') }}
                    </span>
                </div>
            </div>

            <!-- Featured Content Section -->
            <div class="mb-8">
                @if($edukasi->video_url)
                    <div class="mb-6">
                        <!-- Video Title -->
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                                <i class="fas fa-play-circle text-red-500 mr-3"></i>
                                Learning Video
                            </h2>
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-clock mr-2"></i>
                                {{ $edukasi->created_at->format('d M Y') }}
                            </div>
                        </div>

                        <!-- Video Player -->
                        <div class="bg-gray-900 rounded-xl overflow-hidden shadow-2xl">
                            <div class="video-wrapper">
                                <div class="relative">
                                    <video 
                                        id="edukasiVideo"
                                        controls 
                                        class="w-full rounded-lg"
                                        controlsList="nodownload"
                                        preload="metadata"
                                        poster="{{ $edukasi->gambar ? asset('storage/' . $edukasi->gambar) : '' }}"
                                        onloadeddata="console.log('Video loaded successfully')"
                                        onerror="console.error('Error loading video:', this.error)"
                                    >
                                        <source src="{{ asset('storage/' . $edukasi->video_url) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>

                            <!-- Video Controls Info -->
                            <div class="p-4 text-white text-sm">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <button onclick="toggleFullscreen()" class="hover:text-blue-400 transition-colors duration-200">
                                            <i class="fas fa-expand mr-2"></i>
                                            Fullscreen
                                        </button>
                                        <button onclick="togglePlayPause()" class="hover:text-blue-400 transition-colors duration-200">
                                            <i class="fas fa-play mr-2"></i>
                                            Play/Pause
                                        </button>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-video mr-2 text-blue-400"></i>
                                        <span id="videoQuality">HD</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Video Information -->
                        <div class="mt-4 bg-gray-50 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $edukasi->judul_konten }}</h3>
                                    <div class="flex items-center text-sm text-gray-600 space-x-4">
                                        <span class="flex items-center">
                                            <i class="fas fa-folder mr-2 text-blue-500"></i>
                                            {{ ucfirst($edukasi->kategori) }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-tag mr-2 text-green-500"></i>
                                            {{ ucfirst($edukasi->jenis_konten) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($edukasi->gambar)
                    <div class="mb-6">
                        <img src="{{ asset('storage/' . $edukasi->gambar) }}" 
                             alt="{{ $edukasi->judul_konten }}" 
                             class="w-full h-auto rounded-xl shadow-lg">
                    </div>
                @endif
            </div>

            <!-- Main Content -->
            <div class="prose max-w-none">
                <!-- Full Content -->
                <div class="mt-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b">
                        <i class="fas fa-book-open text-blue-500 mr-2"></i>
                        Full Content
                    </h2>
                    <div class="content-body">
                        {!! $edukasi->konten !!}
                    </div>
                </div>
            </div>

            <!-- Related Content -->
            @if($relatedContent->count() > 0)
                <div class="mt-12 pt-8 border-t">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-link text-blue-500 mr-2"></i>
                        Related Content
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($relatedContent as $related)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">
                                @if($related->gambar)
                                    <div class="relative h-48 overflow-hidden">
                                        <img src="{{ asset('storage/' . $related->gambar) }}" 
                                             alt="{{ $related->judul_konten }}"
                                             class="w-full h-full object-cover transform transition duration-300 hover:scale-110">
                                        @if($related->jenis_konten == 'video')
                                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                                <i class="fas fa-play-circle text-white text-5xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                                        <a href="{{ route('edukasi.show', $related->id) }}" 
                                           class="hover:text-blue-600 transition-colors duration-200">
                                            {{ $related->judul_konten }}
                                        </a>
                                    </h3>
                                    <div class="flex items-center text-sm text-gray-600 gap-4">
                                        <span class="flex items-center">
                                            <i class="fas fa-{{ $related->jenis_konten == 'video' ? 'video' : 'file-alt' }} mr-2 text-{{ $related->jenis_konten == 'video' ? 'red' : 'blue' }}-500"></i>
                                            {{ ucfirst($related->jenis_konten) }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                            {{ $related->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .prose img {
        max-width: 100%;
        height: auto;
        border-radius: 0.75rem;
        margin: 2rem 0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .prose h1, .prose h2, .prose h3, .prose h4 {
        color: #1a202c;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .prose h2 {
        font-size: 1.5rem;
        line-height: 2rem;
    }

    .prose h3 {
        font-size: 1.25rem;
        line-height: 1.75rem;
    }

    .prose p {
        margin: 1.5rem 0;
        line-height: 1.8;
        color: #4a5568;
    }

    .prose ul, .prose ol {
        margin: 1.5rem 0;
        padding-left: 2rem;
    }

    .prose li {
        margin: 0.5rem 0;
        color: #4a5568;
    }

    .prose blockquote {
        margin: 2rem 0;
        padding: 1rem 1.5rem;
        border-left: 4px solid #4299e1;
        background-color: #f7fafc;
        font-style: italic;
        color: #4a5568;
    }

    .video-wrapper {
        padding: 20px;
    }

    .video-wrapper video {
        max-height: 600px;
        margin: 0 auto;
        display: block;
    }

    /* Remove the old aspect ratio styles */
    .aspect-w-16 {
        position: static;
        padding-bottom: 0;
        height: auto;
        overflow: visible;
    }

    .aspect-w-16 video {
        position: static;
        width: auto;
        height: auto;
        max-width: 100%;
    }

    video::-webkit-media-controls {
        background-color: rgba(0, 0, 0, 0.7);
    }

    video::-webkit-media-controls-panel {
        padding: 0 12px;
    }

    video::-webkit-media-controls-play-button {
        color: white;
    }

    .video-container:fullscreen video {
        border-radius: 0;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .content-body {
        font-size: 1.125rem;
        line-height: 1.8;
    }

    .content-body > *:first-child {
        margin-top: 0;
    }

    /* Custom hover animations */
    .transform {
        transition-property: transform;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }

    .hover\:scale-110:hover {
        transform: scale(1.1);
    }
</style>
@endpush

@push('scripts')
<script>
    const video = document.getElementById('edukasiVideo');

    function toggleFullscreen() {
        if (!document.fullscreenElement) {
            if (video.requestFullscreen) {
                video.requestFullscreen();
            } else if (video.webkitRequestFullscreen) {
                video.webkitRequestFullscreen();
            } else if (video.msRequestFullscreen) {
                video.msRequestFullscreen();
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        }
    }

    function togglePlayPause() {
        if (video.paused) {
            video.play();
        } else {
            video.pause();
        }
    }

    // Update play/pause button icon
    video.addEventListener('play', function() {
        const playButton = document.querySelector('button i.fa-play');
        if (playButton) {
            playButton.classList.remove('fa-play');
            playButton.classList.add('fa-pause');
        }
    });

    video.addEventListener('pause', function() {
        const pauseButton = document.querySelector('button i.fa-pause');
        if (pauseButton) {
            pauseButton.classList.remove('fa-pause');
            pauseButton.classList.add('fa-play');
        }
    });

    // Handle keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.code === 'Space' && document.activeElement.tagName !== 'BUTTON') {
            e.preventDefault();
            togglePlayPause();
        } else if (e.code === 'KeyF') {
            e.preventDefault();
            toggleFullscreen();
        }
    });
</script>
@endpush
