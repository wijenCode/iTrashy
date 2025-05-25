<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Sembako;

class TukarPoinController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $user = auth()->user();

        // Fetch the total points of the user
        $poin_terkumpul = $user->poin_terkumpul ?? 0;

        // Fetch available vouchers and sembakos
        $vouchers = Voucher::where('status', 'tersedia')->get();
        $sembakos = Sembako::where('status', 'tersedia')->get();

        // Return the view with the fetched data
        return view('user.tukar_poin.index', compact('poin_terkumpul', 'vouchers', 'sembakos'));
    }

    // Tambahkan method untuk tukar voucher
    public function tukarVoucher(Request $request, $id)
    {
        $user = auth()->user();
        $voucher = \App\Models\Voucher::findOrFail($id);

        // Cek apakah poin user cukup
        if ($user->poin_terkumpul < $voucher->poin) {
            return redirect()->back()->with('tukar_status', [
                'success' => false,
                'message' => 'Poin Anda tidak mencukupi untuk menukar voucher ini.'
            ]);
        }

        // Kurangi poin user
        $user->poin_terkumpul -= $voucher->poin;
        $user->save();

        // Simpan transaksi
        \App\Models\TransaksiVoucher::create([
            'user_id' => $user->id,
            'voucher_id' => $voucher->id,
            'tanggal_transaksi' => now(),
            'status' => 'berhasil',
        ]);

        // (Opsional) Kurangi jumlah voucher jika ada stok
        if ($voucher->jumlah_voucher > 0) {
            $voucher->jumlah_voucher -= 1;
            $voucher->save();
        }

        return redirect()->back()->with('tukar_status', [
            'success' => true,
            'message' => 'Penukaran voucher berhasil!'
        ]);
    }

    // Tambahkan method untuk tukar sembako
    public function tukarSembako(Request $request, $id)
    {
        $user = auth()->user();
        $sembako = \App\Models\Sembako::findOrFail($id);

        // Cek apakah poin user cukup
        if ($user->poin_terkumpul < $sembako->poin) {
            return redirect()->back()->with('tukar_status', [
                'success' => false,
                'message' => 'Poin Anda tidak mencukupi untuk menukar sembako ini.'
            ]);
        }

        // Kurangi poin user
        $user->poin_terkumpul -= $sembako->poin;
        $user->save();

        // Simpan transaksi
        \App\Models\TransaksiSembako::create([
            'user_id' => $user->id,
            'sembako_id' => $sembako->id,
            'tanggal_transaksi' => now(),
            'status' => 'berhasil',
        ]);

        // (Opsional) Kurangi jumlah barang jika ada stok
        if ($sembako->jumlah_barang > 0) {
            $sembako->jumlah_barang -= 1;
            $sembako->save();
        }

        return redirect()->back()->with('tukar_status', [
            'success' => true,
            'message' => 'Penukaran sembako berhasil!'
        ]);
    }
}