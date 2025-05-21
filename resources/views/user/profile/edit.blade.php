@extends('layouts.app')

@section('page-title', 'Edit Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Profile</h1>
            <p class="text-gray-600">Perbarui informasi profil dan alamat Anda</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                <div class="p-8">
                    <!-- Profile Image Section -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-camera text-blue-500 mr-2"></i>
                            Foto Profil
        </h2>
                        <div class="flex items-center space-x-6">
                            <div class="w-24 h-24 bg-gray-200 rounded-full overflow-hidden">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-blue-100 text-blue-500">
                                        <i class="fas fa-user text-3xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*">
                                <label for="avatar" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg cursor-pointer transition-colors duration-200">
                                    <i class="fas fa-upload mr-2"></i>
                                    Upload Foto
                                </label>
                                <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB.</p>
                            </div>
                </div>
            </div>

                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-user-circle text-blue-500 mr-2"></i>
                            Informasi Dasar
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                @error('username')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. Handphone</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->no_telepon) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                </div>
            </div>

                    <!-- Address Information -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                            Alamat
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kota" class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten</label>
                                <input type="text" name="kota" id="kota" 
                                    value="{{ old('kota', $user->kota) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Contoh: Kota Bandung">
                                @error('kota')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                                <input type="text" name="kecamatan" id="kecamatan" 
                                    value="{{ old('kecamatan', $user->kecamatan) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Contoh: Cibeunying Kidul">
                                @error('kecamatan')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                             
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                                <textarea name="alamat" id="alamat" rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                                @error('alamat')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('profile.show') }}" 
                   class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>
                    <span>Batal</span>
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    <span>Simpan Perubahan</span>
                </button>
        </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview uploaded image
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.querySelector('.w-24.h-24 img');
    
    avatarInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (avatarPreview) {
                    avatarPreview.src = e.target.result;
                } else {
                    const newPreview = document.createElement('img');
                    newPreview.src = e.target.result;
                    newPreview.classList.add('w-full', 'h-full', 'object-cover');
                    document.querySelector('.w-24.h-24').innerHTML = '';
                    document.querySelector('.w-24.h-24').appendChild(newPreview);
                }
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
});
</script>
@endpush
@endsection