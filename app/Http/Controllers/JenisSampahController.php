<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use Illuminate\Http\Request;

class JenisSampahController extends Controller
{
    // Menampilkan semua jenis sampah
    public function index()
    {
        $jenisSampah = JenisSampah::all();
        return view('admin.jenis-sampah.index', compact('jenisSampah'));
    }

    // Menampilkan form untuk membuat jenis sampah baru
    public function create()
    {
        return view('admin.jenis-sampah.create');
    }

    // Menyimpan jenis sampah baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_sampah' => 'required',
            'poin_per_kg' => 'required|integer',
            'carbon_reduced' => 'required|numeric',
            'kategori_sampah' => 'required',
            'gambar' => 'required|image'
        ]);

        $imagePath = $request->file('gambar')->store('images/jenis_sampah', 'public');

        JenisSampah::create([
            'nama_sampah' => $request->nama_sampah,
            'poin_per_kg' => $request->poin_per_kg,
            'carbon_reduced' => $request->carbon_reduced,
            'kategori_sampah' => $request->kategori_sampah,
            'gambar' => $imagePath
        ]);

        return redirect()->route('admin.jenis-sampah.index');
    }

    // Menampilkan form untuk mengedit jenis sampah
    public function edit(JenisSampah $jenisSampah)
    {
        return view('admin.jenis-sampah.edit', compact('jenisSampah'));
    }

    // Memperbarui data jenis sampah
    public function update(Request $request, JenisSampah $jenisSampah)
    {
        $request->validate([
            'nama_sampah' => 'required',
            'poin_per_kg' => 'required|integer',
            'carbon_reduced' => 'required|numeric',
            'kategori_sampah' => 'required',
            'gambar' => 'nullable|image'
        ]);

        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('images/jenis_sampah', 'public');
            $jenisSampah->gambar = $imagePath;
        }

        $jenisSampah->nama_sampah = $request->nama_sampah;
        $jenisSampah->poin_per_kg = $request->poin_per_kg;
        $jenisSampah->carbon_reduced = $request->carbon_reduced;
        $jenisSampah->kategori_sampah = $request->kategori_sampah;
        $jenisSampah->save();

        return redirect()->route('admin.jenis-sampah.index');
    }

    // Menghapus jenis sampah
    public function destroy(JenisSampah $jenisSampah)
    {
        $jenisSampah->delete();
        return redirect()->route('admin.jenis-sampah.index');
    }
}
