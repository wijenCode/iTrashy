<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EdukasiController extends Controller
{
    /**
     * Get all edukasi content with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $edukasi = Edukasi::orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $edukasi
        ]);
    }

    /**
     * Get edukasi content by ID
     */
    public function show($id)
    {
        $edukasi = Edukasi::findOrFail($id);
        
        // Get related content
        $relatedContent = Edukasi::where('id', '!=', $id)
            ->where(function($query) use ($edukasi) {
                $query->where('kategori', $edukasi->kategori)
                      ->orWhere('jenis_konten', $edukasi->jenis_konten);
            })
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'edukasi' => $edukasi,
                'related_content' => $relatedContent
            ]
        ]);
    }

    /**
     * Get edukasi content by category
     */
    public function byCategory($category)
    {
        $edukasi = Edukasi::where('kategori', $category)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $edukasi
        ]);
    }

    /**
     * Get edukasi content by type (artikel/video)
     */
    public function byType($type)
    {
        $edukasi = Edukasi::where('jenis_konten', $type)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $edukasi
        ]);
    }

    /**
     * Get all categories
     */
    public function categories()
    {
        $categories = Edukasi::select('kategori')
            ->distinct()
            ->pluck('kategori');

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    /**
     * Get all content types
     */
    public function types()
    {
        $types = Edukasi::select('jenis_konten')
            ->distinct()
            ->pluck('jenis_konten');

        return response()->json([
            'status' => 'success',
            'data' => $types
        ]);
    }

    /**
     * Search edukasi content
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        
        $edukasi = Edukasi::where('judul_konten', 'like', "%{$query}%")
            ->orWhere('konten', 'like', "%{$query}%")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $edukasi
        ]);
    }
} 