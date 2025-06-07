<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use Illuminate\Http\Request;
use App\Http\Resources\EdukasiResource;
use Illuminate\Support\Facades\Storage;

class EdukasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $edukasi = Edukasi::all();
        return EdukasiResource::collection($edukasi);
    }

    /**
     * Display the specified resource.
     */
    public function show(Edukasi $edukasi)
    {
        return new EdukasiResource($edukasi);
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