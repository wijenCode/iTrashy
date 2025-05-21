@extends('layouts.admin-app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-semibold mb-6">Manajemen Jenis Sampah</h1>
    <a href="{{ route('admin.jenis-sampah.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4 inline-block">Tambah Jenis Sampah</a>

    <table class="min-w-full bg-white border border-gray-300 shadow-lg">
        <thead>
            <tr>
                <th class="px-4 py-2 border">Nama Sampah</th>
                <th class="px-4 py-2 border">Poin per Kg</th>
                <th class="px-4 py-2 border">Carbon Reduced</th>
                <th class="px-4 py-2 border">Kategori Sampah</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jenisSampah as $sampah)
                <tr>
                    <td class="px-4 py-2 border">{{ $sampah->nama_sampah }}</td>
                    <td class="px-4 py-2 border">{{ $sampah->poin_per_kg }}</td>
                    <td class="px-4 py-2 border">{{ $sampah->carbon_reduced }}</td>
                    <td class="px-4 py-2 border">{{ $sampah->kategori_sampah }}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('admin.jenis-sampah.edit', $sampah->id) }}" class="text-blue-500">Edit</a> | 
                        <form action="{{ route('admin.jenis-sampah.destroy', $sampah->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
