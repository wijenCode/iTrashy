<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiTransfer;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransaksiTransferController extends Controller
{
    public function index()
    {
        $transaksiTransfer = TransaksiTransfer::all();
        return response()->json($transaksiTransfer);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'transfer_id' => 'required|integer',
            'tanggal_transaksi' => 'required|date',
            'status' => 'required|string',
        ]);

        $transaksiTransfer = TransaksiTransfer::create($request->all());
        return response()->json($transaksiTransfer, 201);
    }

    public function show($id)
    {
        $transaksiTransfer = TransaksiTransfer::find($id);
        if (!$transaksiTransfer) {
            return response()->json(['message' => 'Transaksi Transfer not found'], 404);
        }
        return response()->json($transaksiTransfer);
    }
}