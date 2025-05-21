<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiDonasi;
use App\Models\Donasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransaksiDonasiController extends Controller
{
    public function index()
    {
        $transaksiDonasi = TransaksiDonasi::all();
        return response()->json($transaksiDonasi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'donasi_id' => 'required|integer',
            'tanggal_transaksi' => 'required|date',
            'status' => 'required|string',
        ]);

        $transaksiDonasi = TransaksiDonasi::create($request->all());
        return response()->json($transaksiDonasi, 201);
    }

    public function show($id)
    {
        $transaksiDonasi = TransaksiDonasi::find($id);
        if (!$transaksiDonasi) {
            return response()->json(['message' => 'Transaksi Donasi not found'], 404);
        }
        return response()->json($transaksiDonasi);
    }
}