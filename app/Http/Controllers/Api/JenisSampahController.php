<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class JenisSampahController extends Controller
{
    /**
     * Display a listing of jenis sampah
     */
    public function index(Request $request)
    {
        $query = JenisSampah::query();

        // Filter by kategori if provided
        if ($request->has('kategori')) {
            $query->where('kategori_sampah', $request->kategori);
        }

        // Search by nama if provided
        if ($request->has('search')) {
            $query->where('nama_sampah', 'like', '%' . $request->search . '%');
        }

        $jenisSampah = $query->orderBy('nama_sampah')->get();

        return response()->json([
            'success' => true,
            'data' => $jenisSampah
        ]);
    }

    /**
     * Show specific jenis sampah
     */
    public function show($id)
    {
        $jenisSampah = JenisSampah::find($id);

        if (!$jenisSampah) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $jenisSampah
        ]);
    }

    /**
     * Store a newly created jenis sampah (Admin only)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_sampah' => 'required|string|max:255|unique:jenis_sampah',
            'poin_per_kg' => 'required|numeric|min:0',
            'carbon_reduced' => 'required|numeric|min:0',
            'kategori_sampah' => 'required|string|in:organik,anorganik,b3,elektronik',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['nama_sampah', 'poin_per_kg', 'carbon_reduced', 'kategori_sampah']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('jenis_sampah', $filename, 'public');
            $data['gambar'] = $path;
        }

        $jenisSampah = JenisSampah::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Jenis sampah berhasil ditambahkan',
            'data' => $jenisSampah
        ], 201);
    }

    /**
     * Update jenis sampah (Admin only)
     */
    public function update(Request $request, $id)
    {
        $jenisSampah = JenisSampah::find($id);

        if (!$jenisSampah) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_sampah' => 'required|string|max:255|unique:jenis_sampah,nama_sampah,' . $id,
            'poin_per_kg' => 'required|numeric|min:0',
            'carbon_reduced' => 'required|numeric|min:0',
            'kategori_sampah' => 'required|string|in:organik,anorganik,b3,elektronik',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['nama_sampah', 'poin_per_kg', 'carbon_reduced', 'kategori_sampah']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($jenisSampah->gambar && Storage::disk('public')->exists($jenisSampah->gambar)) {
                Storage::disk('public')->delete($jenisSampah->gambar);
            }

            $image = $request->file('gambar');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('jenis_sampah', $filename, 'public');
            $data['gambar'] = $path;
        }

        $jenisSampah->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Jenis sampah berhasil diupdate',
            'data' => $jenisSampah
        ]);
    }

    /**
     * Remove jenis sampah (Admin only)
     */
    public function destroy($id)
    {
        $jenisSampah = JenisSampah::find($id);

        if (!$jenisSampah) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Check if jenis sampah is being used in setor_item
        if ($jenisSampah->setorItems()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis sampah tidak dapat dihapus karena sedang digunakan'
            ], 422);
        }

        // Delete image if exists
        if ($jenisSampah->gambar && Storage::disk('public')->exists($jenisSampah->gambar)) {
            Storage::disk('public')->delete($jenisSampah->gambar);
        }

        $jenisSampah->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jenis sampah berhasil dihapus'
        ]);
    }
}