@extends('layouts.admin-app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-3xl font-semibold text-gray-800">Manajemen Edukasi</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.edukasi.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Edukasi
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4 bg-green-100 text-green-700 border-l-4 border-green-500 p-4">
        {{ session('success') }}
        <button type="button" class="close text-green-700" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-4 py-2 bg-blue-100">
            <h6 class="font-semibold text-lg text-blue-600">Daftar Edukasi</h6>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left border-b">No</th>
                            <th class="px-4 py-2 text-left border-b">Judul</th>
                            <th class="px-4 py-2 text-left border-b">Kategori</th>
                            <th class="px-4 py-2 text-left border-b">Jenis Konten</th>
                            <th class="px-4 py-2 text-left border-b">Tanggal Dibuat</th>
                            <th class="px-4 py-2 text-left border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($edukasi as $item)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border-b">{{ $item->judul_konten }}</td>
                            <td class="px-4 py-2 border-b">{{ ucfirst($item->kategori) }}</td>
                            <td class="px-4 py-2 border-b">{{ ucfirst($item->jenis_konten) }}</td>
                            <td class="px-4 py-2 border-b">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2 border-b">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.edukasi.show', $item->id) }}" 
                                       class="bg-blue-500 text-white py-1 px-3 rounded-lg hover:bg-blue-600">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('admin.edukasi.edit', $item->id) }}" 
                                       class="bg-yellow-500 text-white py-1 px-3 rounded-lg hover:bg-yellow-600">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.edukasi.destroy', $item->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded-lg hover:bg-red-600">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-center text-gray-500">Tidak ada data edukasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush