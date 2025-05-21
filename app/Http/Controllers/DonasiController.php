<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donasi;
use App\Models\TransaksiDonasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DonasiController extends Controller
{
    public function index()
    {
        $donasi = Donasi::all();
        return response()->json($donasi);
    }

    public function show($id)
    {
        $donasi = Donasi::find($id);
        if (!$donasi) {
            return response()->json(['message' => 'Donasi not found'], 404);
        }
        return response()->json($donasi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_donasi' => 'required|string',
            'deskripsi' => 'required|string',
            'donasi_terkumpul' => 'required|numeric',
            'target_donasi' => 'required|numeric',
            'gambar' => 'required|string',
        ]);

        $donasi = Donasi::create($request->all());
        return response()->json($donasi, 201);
    }

    public function update(Request $request, $id)
    {
        $donasi = Donasi::find($id);
        if (!$donasi) {
            return response()->json(['message' => 'Donasi not found'], 404);
        }

        $donasi->update($request->all());
        return response()->json($donasi);
    }

    public function destroy($id)
    {
        $donasi = Donasi::find($id);
        if (!$donasi) {
            return response()->json(['message' => 'Donasi not found'], 404);
        }

        $donasi->delete();
        return response()->json(['message' => 'Donasi deleted']);
    }
}