<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use Illuminate\Http\Request;

class EdukasiUserController extends Controller
{
    /**
     * Menampilkan daftar edukasi untuk user
     */
    public function index()
    {
        $edukasi = Edukasi::orderBy('created_at', 'desc')->paginate(9);
        return view('user.edukasi.index', compact('edukasi'));
    }

    /**
     * Menampilkan detail edukasi berdasarkan ID
     */
    public function show($id)
    {
        $edukasi = Edukasi::findOrFail($id);
        
        // Mengambil konten terkait berdasarkan kategori atau jenis_konten yang sama
        $relatedContent = Edukasi::where('id', '!=', $id)
            ->where(function($query) use ($edukasi) {
                $query->where('kategori', $edukasi->kategori)
                      ->orWhere('jenis_konten', $edukasi->jenis_konten);
            })
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('user.edukasi.show', compact('edukasi', 'relatedContent'));
    }

    /**
     * Menampilkan edukasi berdasarkan kategori
     */
    public function kategori($kategori)
    {
        $edukasi = Edukasi::where('kategori', $kategori)
                          ->orderBy('created_at', 'desc')
                          ->paginate(9);
        
        // Get counts for each jenis_konten in this kategori
        $jenisCounts = Edukasi::where('kategori', $kategori)
                             ->selectRaw('jenis_konten, count(*) as count')
                             ->groupBy('jenis_konten')
                             ->pluck('count', 'jenis_konten');
        
        return view('user.edukasi.kategori', compact('edukasi', 'kategori', 'jenisCounts'));
    }

    /**
     * Menampilkan edukasi berdasarkan jenis konten
     */
    public function jenisKonten($jenis)
    {
        $edukasi = Edukasi::where('jenis_konten', $jenis)
                          ->orderBy('created_at', 'desc')
                          ->paginate(9);
        
        // Get counts for each kategori in this jenis
        $kategoriCounts = Edukasi::where('jenis_konten', $jenis)
                                ->selectRaw('kategori, count(*) as count')
                                ->groupBy('kategori')
                                ->pluck('count', 'kategori');
        
        return view('user.edukasi.jenis', compact('edukasi', 'jenis', 'kategoriCounts'));
    }
} 