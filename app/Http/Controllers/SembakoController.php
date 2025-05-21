<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sembako;
use App\Models\TransaksiSembako;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SembakoController extends Controller
{
    public function index()
    {
        $sembako = Sembako::all();
        return response()->json($sembako);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sembako' => 'required|string',
            'deskripsi' => 'required|string',
            'jumlah_barang' => 'required|integer',
            'poin' => 'required|numeric',
            'gambar' => 'required|string',
            'status' => 'required|string',
        ]);

        $sembako = Sembako::create($request->all());
        return response()->json($sembako, 201);
    }

    public function show($id)
    {
        $sembako = Sembako::findOrFail($id);
        return view('sembako.detail', compact('sembako'));
    }

    public function update(Request $request, $id)
    {
        $sembako = Sembako::find($id);
        if (!$sembako) {
            return response()->json(['message' => 'Sembako not found'], 404);
        }

        $sembako->update($request->all());
        return response()->json($sembako);
    }

    public function destroy($id)
    {
        $sembako = Sembako::find($id);
        if (!$sembako) {
            return response()->json(['message' => 'Sembako not found'], 404);
        }

        $sembako->delete();
        return response()->json(['message' => 'Sembako deleted']);
    }
}