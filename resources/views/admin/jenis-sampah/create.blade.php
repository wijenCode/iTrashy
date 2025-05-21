@extends('layouts.admin-app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-semibold mb-6">Tambah Jenis Sampah</h1>
    <form action="{{ route('admin.jenis-sampah.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Nama Sampah -->
        <div class="mb-4">
            <label for="nama_sampah" class="block text-sm font-medium text-gray-700">Nama Sampah</label>
            <input type="text" id="nama_sampah" name="nama_sampah" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        </div>

        <!-- Poin per Kg -->
        <div class="mb-4">
            <label for="poin_per_kg" class="block text-sm font-medium text-gray-700">Poin per Kg</label>
            <input type="number" id="poin_per_kg" name="poin_per_kg" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        </div>

        <!-- Carbon Reduced -->
        <div class="mb-4">
            <label for="carbon_reduced" class="block text-sm font-medium text-gray-700">Carbon Reduced</label>
            <input type="number" id="carbon_reduced" name="carbon_reduced" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        </div>

        {{-- Kategori Sampah --}}
        <div>
            <label for="kategori_sampah" class="block text-sm font-medium text-gray-700">Kategori Sampah</label>
            <input type="text" id="kategori_sampah" name="kategori_sampah" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        </div>

        <!-- Gambar -->
        <div class="mb-4">
            <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar</label>
            <input type="file" id="gambar" name="gambar" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Simpan</button>
    </form>
</div>
@endsection
