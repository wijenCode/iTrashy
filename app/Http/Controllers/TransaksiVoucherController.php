<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiVoucher;
use App\Models\Voucher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransaksiVoucherController extends Controller
{
    public function index()
    {
        $transaksiVoucher = TransaksiVoucher::all();
        return response()->json($transaksiVoucher);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'voucher_id' => 'required|integer',
            'tanggal_transaksi' => 'required|date',
            'status' => 'required|string',
        ]);

        $transaksiVoucher = TransaksiVoucher::create($request->all());
        return response()->json($transaksiVoucher, 201);
    }

    public function show($id)
    {
        $transaksiVoucher = TransaksiVoucher::find($id);
        if (!$transaksiVoucher) {
            return response()->json(['message' => 'Transaksi Voucher not found'], 404);
        }
        return response()->json($transaksiVoucher);
    }
}