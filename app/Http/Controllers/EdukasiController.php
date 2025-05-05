<?php

// app/Http/Controllers/EdukasiController.php
namespace App\Http\Controllers;

use App\Models\Edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EdukasiController extends Controller
{
    // Menampilkan daftar edukasi
    public function index()
    {
        $edukasi = Edukasi::orderBy('created_at', 'desc')->get();
        return view('admin.edukasi.index', compact('edukasi'));
    }

    // Menampilkan detail edukasi berdasarkan ID
    public function show($id)
    {
        $edukasi = Edukasi::findOrFail($id);
        return view('admin.edukasi.show', compact('edukasi'));
    }

    // Menampilkan form untuk membuat edukasi baru
    public function create()
    {
        return view('admin.edukasi.create');
    }

    // Menyimpan edukasi baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_konten' => 'required|max:255',
            'konten' => 'required',
            'jenis_konten' => 'required',
            'kategori' => 'required',
            'video_url' => 'nullable|mimes:mp4,mov,ogg,qt|max:102400', // 100MB max
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle video upload
        if ($request->hasFile('video_url')) {
            $video = $request->file('video_url');
            $videoPath = $video->store('videos', 'public');
            $validated['video_url'] = $videoPath;
        }

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarPath = $gambar->store('edukasi', 'public');
            $validated['gambar'] = $gambarPath;
        }

        $validated['user_id'] = auth()->id();
        
        Edukasi::create($validated);

        return redirect()->route('admin.edukasi.index')
            ->with('success', 'Konten edukasi berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit edukasi
    public function edit($id)
    {
        $edukasi = Edukasi::findOrFail($id);
        return view('admin.edukasi.edit', compact('edukasi'));
    }

    // Mengupdate edukasi di database
    public function update(Request $request, $id)
    {
        $edukasi = Edukasi::findOrFail($id);

        $validated = $request->validate([
            'judul_konten' => 'required|max:255',
            'konten' => 'required',
            'jenis_konten' => 'required',
            'kategori' => 'required',
            'video_url' => 'nullable|mimes:mp4,mov,ogg,qt|max:102400', // 100MB max
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle video upload
        if ($request->hasFile('video_url')) {
            // Delete old video if exists
            if ($edukasi->video_url) {
                Storage::disk('public')->delete($edukasi->video_url);
            }
            
            $video = $request->file('video_url');
            $videoPath = $video->store('videos', 'public');
            $validated['video_url'] = $videoPath;
        } elseif ($request->has('remove_video')) {
            // If remove video is checked, delete the video
            if ($edukasi->video_url) {
                Storage::disk('public')->delete($edukasi->video_url);
                $validated['video_url'] = null;
            }
        }

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($edukasi->gambar) {
                Storage::disk('public')->delete($edukasi->gambar);
            }
            
            $gambar = $request->file('gambar');
            $gambarPath = $gambar->store('edukasi', 'public');
            $validated['gambar'] = $gambarPath;
        } elseif ($request->has('remove_image')) {
            // If remove image is checked, delete the image
            if ($edukasi->gambar) {
                Storage::disk('public')->delete($edukasi->gambar);
                $validated['gambar'] = null;
            }
        }

        $edukasi->update($validated);

        return redirect()->route('admin.edukasi.index')
            ->with('success', 'Konten edukasi berhasil diperbarui');
    }

    // Menghapus edukasi dari database
    public function destroy($id)
    {
        try {
            $edukasi = Edukasi::findOrFail($id);
            
            // Delete video if exists
            if ($edukasi->video_url) {
                Storage::disk('public')->delete($edukasi->video_url);
            }
            
            // Delete image if exists
            if ($edukasi->gambar) {
                Storage::disk('public')->delete($edukasi->gambar);
            }
            
            $edukasi->delete();

            return redirect()->route('admin.edukasi.index')
                ->with('success', 'Konten edukasi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.edukasi.index')
                ->with('error', 'Gagal menghapus konten edukasi. Error: ' . $e->getMessage());
        }
    }
}