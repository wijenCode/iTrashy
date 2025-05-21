@extends('layouts.app')
@section('page-title', 'Profile')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Profile Header -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="p-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div class="flex items-center space-x-4">
                        <!-- Profile Image -->
                        <div class="w-20 md:w-24 h-20 md:h-24 bg-gray-200 rounded-full overflow-hidden flex-shrink-0">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600 text-white">
                                    <i class="fas fa-user text-2xl md:text-3xl"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h1 class="text-xl md:text-2xl font-bold text-gray-800">{{ $user->username }}</h1>
                            <p class="text-gray-600 text-sm md:text-base">{{ $user->role ?? 'Pengguna Individu' }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg text-sm md:text-base w-full md:w-auto">
                            <i class="fas fa-edit mr-2"></i>
                            <span>Edit Profile</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline w-full md:w-auto">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center justify-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg w-full text-sm md:text-base">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Information -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-8">
                <!-- Basic Information -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user-circle text-blue-500 mr-2"></i>
                        Informasi Dasar
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Username</label>
                            <p class="text-gray-800 mt-1 p-2 w-full border rounded-lg bg-gray-50">{{ $user->username }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                            <p class="text-gray-800 mt-1 p-2 w-full border rounded-lg bg-gray-50">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">No. Handphone</label>
                            <p class="text-gray-800 mt-1 p-2 w-full border rounded-lg bg-gray-50">{{ $user->no_telepon ?? 'Belum diatur' }}</p>
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
                            <label class="block text-sm font-medium text-gray-600 mb-1">Kota/Kabupaten</label>
                            <p class="text-gray-800 mt-1 p-2 w-full border rounded-lg bg-gray-50">{{ $user->kota ?? 'Belum diatur' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Kecamatan</label>
                            <p class="text-gray-800 mt-1 p-2 w-full border rounded-lg bg-gray-50">{{ $user->kecamatan ?? 'Belum diatur' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-600 mb-1">Alamat Lengkap</label>
                            <p class="text-gray-800 mt-1 p-2 w-full border rounded-lg bg-gray-50">{{ $user->alamat ?? 'Belum diatur' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection