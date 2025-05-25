<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\TransaksiVoucher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    public function index()
    {
        $voucher = Voucher::all();
        return response()->json($voucher);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_voucher' => 'required|string',
            'deskripsi' => 'required|string',
            'jumlah_voucher' => 'required|integer',
            'poin' => 'required|numeric',
            'gambar' => 'required|string',
            'status' => 'required|string',
        ]);

        $voucher = Voucher::create($request->all());
        return response()->json($voucher, 201);
    }

    public function show($id)
    {
        $voucher = \App\Models\Voucher::findOrFail($id);
        $vouchers = \App\Models\Voucher::where('id', '!=', $id)->where('status', 'tersedia')->get();

        // Contoh rincian, bisa diambil dari kolom lain atau diolah
        $voucher->rincian = [
            'Voucher berlaku selama tujuh hari',
            'Min. pembelian Rp 100.000 di indomaret',
            'Cuma bisa dipakai 1x',
            'Berlaku di Indomaret daerah JABODETABEK'
        ];

        return view('user.tukar_poin.voucher_detail', compact('voucher', 'vouchers'));
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::find($id);
        if (!$voucher) {
            return response()->json(['message' => 'Voucher not found'], 404);
        }

        $voucher->update($request->all());
        return response()->json($voucher);
    }

    public function destroy($id)
    {
        $voucher = Voucher::find($id);
        if (!$voucher) {
            return response()->json(['message' => 'Voucher not found'], 404);
        }

        $voucher->delete();
        return response()->json(['message' => 'Voucher deleted']);
    }
}