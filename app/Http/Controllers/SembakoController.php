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
        // Get other sembakos for the "Sembako lainnya" section, excluding the current one
        $sembakos = Sembako::where('id', '!=', $id)->where('status', 'tersedia')->get();

        // Contoh rincian, bisa diambil dari kolom lain atau diolah
        // For now, hardcode some examples
        $sembako->rincian = [
            'Berlaku untuk 1x penukaran',
            'Stok terbatas',
            'Tidak dapat diuangkan',
            'Hanya berlaku di cabang yang terdaftar',
            'Wajib menunjukkan bukti penukaran saat pengambilan'
        ];

        return view('user.tukar_poin.sembako_detail', compact('sembako', 'sembakos'));
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