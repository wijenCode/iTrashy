<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\TransaksiTransfer;

class TransferController extends Controller
{
    public function index()
    {
        $transfer = Transfer::all();
        return response()->json($transfer);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'e_wallet' => 'required|string',
            'no_telepon' => 'required|string',
            'jumlah_transfer' => 'required|numeric',
            'admin_fee' => 'required|numeric',
            'total_transfer' => 'required|numeric',
        ]);

        $transfer = Transfer::create($request->all());
        return response()->json($transfer, 201);
    }

    public function show($id)
    {
        $transfer = Transfer::find($id);
        if (!$transfer) {
            return response()->json(['message' => 'Transfer not found'], 404);
        }
        return response()->json($transfer);
    }

    public function destroy($id)
    {
        $transfer = Transfer::find($id);
        if (!$transfer) {
            return response()->json(['message' => 'Transfer not found'], 404);
        }

        $transfer->delete();
        return response()->json(['message' => 'Transfer deleted']);
    }
}