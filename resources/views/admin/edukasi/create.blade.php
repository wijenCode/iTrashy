@extends('layouts.admin-app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Edukasi</h1>
        <a href="{{ route('admin.edukasi.index') }}" class="bg-gray-600 text-white hover:bg-gray-700 rounded-full px-4 py-2 flex items-center transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-xl">
        <form action="{{ route('admin.edukasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="judul_konten" class="block text-lg font-medium text-gray-700">Judul Konten</label>
                <input type="text" class="mt-1 p-4 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all @error('judul_konten') border-red-500 @enderror" 
                       id="judul_konten" name="judul_konten" value="{{ old('judul_konten') }}" required>
                @error('judul_konten')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-6">
                <label for="konten" class="block text-lg font-medium text-gray-700">Konten</label>
                <textarea class="mt-1 p-4 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all @error('konten') border-red-500 @enderror" 
                          id="konten" name="konten" rows="6" required>{{ old('konten') }}</textarea>
                @error('konten')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-6">
                <label for="jenis_konten" class="block text-lg font-medium text-gray-700">Jenis Konten</label>
                <select class="mt-1 p-4 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all @error('jenis_konten') border-red-500 @enderror" 
                        id="jenis_konten" name="jenis_konten" required>
                    <option value="">Pilih Jenis Konten</option>
                    <option value="artikel" {{ old('jenis_konten') == 'artikel' ? 'selected' : '' }}>Artikel</option>
                    <option value="video" {{ old('jenis_konten') == 'video' ? 'selected' : '' }}>Video</option>
                    <option value="infografis" {{ old('jenis_konten') == 'infografis' ? 'selected' : '' }}>Infografis</option>
                </select>
                @error('jenis_konten')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-6">
                <label for="kategori" class="block text-lg font-medium text-gray-700">Kategori</label>
                <select class="mt-1 p-4 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all @error('kategori') border-red-500 @enderror" 
                        id="kategori" name="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <option value="kesehatan" {{ old('kategori') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                    <option value="pendidikan" {{ old('kategori') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                    <option value="lingkungan" {{ old('kategori') == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                </select>
                @error('kategori')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-6">
                <label for="video_url" class="block text-lg font-medium text-gray-700">Video</label>
                <div class="mt-1">
                    <input type="file" 
                           class="p-4 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all @error('video_url') border-red-500 @enderror" 
                           id="video_url" 
                           name="video_url" 
                           accept="video/*"
                           onchange="previewVideo(this)">
                    <small class="text-sm text-gray-500 block mt-1">Format: MP4, maksimal 100MB</small>
                </div>
                <div id="video_preview_container" class="mt-4 hidden">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Preview Video</h4>
                    <div class="aspect-w-16 aspect-h-9 bg-gray-100 rounded-xl overflow-hidden">
                        <video 
                            id="video_preview"
                            controls 
                            class="w-full h-full rounded-lg object-contain"
                            controlsList="nodownload"
                        >
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="mt-2">
                        <p id="video_info" class="text-sm text-gray-500"></p>
                    </div>
                </div>
                @error('video_url')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-6">
                <label for="gambar" class="block text-lg font-medium text-gray-700">Gambar</label>
                <input type="file" class="mt-1 p-4 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all @error('gambar') border-red-500 @enderror" 
                       id="gambar" name="gambar">
                <small class="text-sm text-gray-500">Format: jpeg, png, jpg, gif. Maksimal 2MB</small>
                @error('gambar')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white py-2 px-8 rounded-lg shadow-md hover:bg-indigo-700 transition-all duration-200">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .aspect-w-16 {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        height: 0;
        overflow: hidden;
        max-width: 100%;
    }

    .aspect-w-16 video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 0.5rem;
        background-color: black;
    }

    video::-webkit-media-controls {
        background-color: rgba(0, 0, 0, 0.5);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#konten'))
        .catch(error => {
            console.error(error);
        });

    function previewVideo(input) {
        const container = document.getElementById('video_preview_container');
        const preview = document.getElementById('video_preview');
        const info = document.getElementById('video_info');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Validate file type
            if (!file.type.startsWith('video/')) {
                alert('Please select a valid video file');
                input.value = '';
                container.classList.add('hidden');
                return;
            }
            
            // Validate file size (100MB)
            if (file.size > 100 * 1024 * 1024) {
                alert('File size should not exceed 100MB');
                input.value = '';
                container.classList.add('hidden');
                return;
            }

            // Create preview
            const url = URL.createObjectURL(file);
            preview.src = url;
            
            // Show container and file info
            container.classList.remove('hidden');
            info.textContent = `File: ${file.name} (${(file.size / (1024 * 1024)).toFixed(2)} MB)`;
            
            // Clean up object URL when video loads
            preview.onload = function() {
                URL.revokeObjectURL(url);
            }
        } else {
            container.classList.add('hidden');
            preview.src = '';
            info.textContent = '';
        }
    }
</script>
@endpush
