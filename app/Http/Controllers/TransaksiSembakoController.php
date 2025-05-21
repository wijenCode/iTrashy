<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiSembako;
use App\Models\Sembako;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransaksiSembakoController extends Controller
{
    // Display all the Transaksi Sembako records
    public function index()
    {
        $transaksiSembako = TransaksiSembako::all();
        return response()->json($transaksiSembako);
    }

    // Create a new Transaksi Sembako record
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'sembako_id' => 'required|integer',
            'tanggal_transaksi' => 'required|date',
            'status' => 'required|string',
        ]);

        $transaksiSembako = TransaksiSembako::create($request->all());
        return response()->json($transaksiSembako, 201);
    }

    // Display a single Transaksi Sembako record
    public function show($id)
    {
        $transaksiSembako = TransaksiSembako::find($id);
        if (!$transaksiSembako) {
            return response()->json(['message' => 'Transaksi Sembako not found'], 404);
        }
        return response()->json($transaksiSembako);
    }

    // Update a Transaksi Sembako record
    public function update(Request $request, $id)
    {
        $transaksiSembako = TransaksiSembako::find($id);
        if (!$transaksiSembako) {
            return response()->json(['message' => 'Transaksi Sembako not found'], 404);
        }

        $transaksiSembako->update($request->all());
        return response()->json($transaksiSembako);
    }

    // Delete a Transaksi Sembako record
    public function destroy($id)
    {
        $transaksiSembako = TransaksiSembako::find($id);
        if (!$transaksiSembako) {
            return response()->json(['message' => 'Transaksi Sembako not found'], 404);
        }

        $transaksiSembako->delete();
        return response()->json(['message' => 'Transaksi Sembako deleted']);
    }
}