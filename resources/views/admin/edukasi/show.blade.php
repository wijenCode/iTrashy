@extends('layouts.admin-app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Detail Edukasi</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.edukasi.index') }}" 
               class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition-colors duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <a href="{{ route('admin.edukasi.edit', $edukasi->id) }}" 
               class="bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600 transition-colors duration-200 flex items-center">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <form action="{{ route('admin.edukasi.destroy', $edukasi->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition-colors duration-200 flex items-center"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus edukasi ini?')">
                    <i class="fas fa-trash mr-2"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <!-- Header Info -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $edukasi->judul_konten }}</h2>
                <div class="flex flex-wrap items-center text-sm text-gray-600 gap-4">
                    <span class="flex items-center">
                        <i class="fas fa-folder mr-2"></i>
                        {{ ucfirst($edukasi->kategori) }}
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-file-alt mr-2"></i>
                        {{ ucfirst($edukasi->jenis_konten) }}
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-calendar mr-2"></i>
                        {{ $edukasi->created_at->format('d M Y H:i') }}
                    </span>
                </div>
            </div>

            <!-- Video -->
            @if($edukasi->video_url)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-play-circle text-blue-500 mr-2"></i>
                        Video Pembelajaran
                    </h3>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Video Player Column -->
                        <div class="lg:col-span-2">
                            <div class="bg-gray-900 rounded-xl overflow-hidden shadow-lg">
                                <div class="video-container p-2">
                                    <video 
                                        controls 
                                        class="w-full rounded-lg"
                                        controlsList="nodownload"
                                        preload="metadata"
                                        id="mainVideo"
                                    >
                                        <source src="{{ asset('storage/' . $edukasi->video_url) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                            <!-- Video Controls -->
                            <div class="bg-white rounded-lg shadow-md mt-4 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <button onclick="document.getElementById('mainVideo').play()" 
                                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                            <i class="fas fa-play mr-2"></i>Play
                                        </button>
                                        <button onclick="document.getElementById('mainVideo').pause()" 
                                                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                                            <i class="fas fa-pause mr-2"></i>Pause
                                        </button>
                                    </div>
                                    <button onclick="toggleFullscreen()" 
                                            class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                                        <i class="fas fa-expand mr-2"></i>Fullscreen
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video Information Column -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-lg shadow-md p-4">
                                <h4 class="font-semibold text-gray-800 mb-4">Informasi Video</h4>
                                <div class="space-y-3">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-file-video text-blue-500 mr-3 w-5"></i>
                                        <span>{{ basename($edukasi->video_url) }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-calendar text-green-500 mr-3 w-5"></i>
                                        <span>{{ $edukasi->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-folder text-yellow-500 mr-3 w-5"></i>
                                        <span>{{ ucfirst($edukasi->kategori) }}</span>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <div class="text-sm text-gray-500">
                                    <p class="mb-2"><i class="fas fa-info-circle mr-2"></i>Petunjuk:</p>
                                    <ul class="space-y-2 pl-5 list-disc">
                                        <li>Klik tombol Play untuk memulai video</li>
                                        <li>Gunakan tombol Fullscreen untuk layar penuh</li>
                                        <li>Tekan SPASI untuk play/pause</li>
                                        <li>Tekan F untuk masuk/keluar mode fullscreen</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Image -->
            @if($edukasi->gambar)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Gambar</h3>
                    <img src="{{ asset('storage/' . $edukasi->gambar) }}" 
                         alt="{{ $edukasi->judul_konten }}" 
                         class="w-full h-auto rounded-lg shadow-md">
                </div>
            @endif

            <!-- Content -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Konten</h3>
                <div class="bg-gray-50 p-4 rounded-lg prose max-w-none">
                    {!! $edukasi->konten !!}
                </div>
            </div>

            <!-- Additional Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Informasi Tambahan</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-sm text-gray-600">
                            <span class="w-32">ID:</span>
                            <span class="font-medium">{{ $edukasi->id }}</span>
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <span class="w-32">Dibuat pada:</span>
                            <span class="font-medium">{{ $edukasi->created_at->format('d M Y H:i') }}</span>
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <span class="w-32">Diperbarui pada:</span>
                            <span class="font-medium">{{ $edukasi->updated_at->format('d M Y H:i') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mb-4">
                <label for="video_url" class="block text-sm font-medium text-gray-700">Video URL (Opsional)</label>
                <input type="url" name="video_url" id="video_url" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                       value="{{ old('video_url', $edukasi->video_url ?? '') }}"
                       placeholder="https://www.youtube.com/embed/...">
                <p class="mt-1 text-sm text-gray-500">Masukkan URL embed video (contoh: URL YouTube embed)</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .video-container {
        background-color: #1a1a1a;
        border-radius: 0.75rem;
    }

    .video-container video {
        max-height: 600px;
        margin: 0 auto;
        display: block;
    }

    video::-webkit-media-controls {
        background-color: rgba(0, 0, 0, 0.5);
    }

    video::-webkit-media-controls-panel {
        padding: 0 12px;
    }

    .prose img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleFullscreen() {
        const video = document.getElementById('mainVideo');
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

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        const video = document.getElementById('mainVideo');
        if (e.code === 'Space' && document.activeElement.tagName !== 'BUTTON' && document.activeElement.tagName !== 'INPUT') {
            e.preventDefault();
            video.paused ? video.play() : video.pause();
        } else if (e.code === 'KeyF') {
            e.preventDefault();
            toggleFullscreen();
    }
    });
</script>
@endpush 