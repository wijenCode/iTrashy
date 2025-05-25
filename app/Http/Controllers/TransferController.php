<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiTransfer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Fetch the total points of the user
        $poin_terkumpul = $user->poin_terkumpul ?? 0;

        // Fetch recent transfer history for the user
        $riwayat_transfer = TransaksiTransfer::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5) // Ambil 5 transfer terakhir
            ->get();

        // Return the view with the fetched data
        return view('user.tukar_poin.transfer.index', compact('poin_terkumpul', 'riwayat_transfer'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_transfer' => 'required|in:bank,e_wallet',
            'nama_penerima' => 'required|string',
            'jumlah_transfer' => 'required|numeric|min:10000',
            'catatan' => 'nullable|string',
        ]);

        // Validasi tambahan berdasarkan jenis transfer
        if ($request->jenis_transfer === 'bank') {
            $request->validate([
                'bank' => 'required|string',
                'nomor_rekening' => 'required|string',
            ]);
        } else {
            $request->validate([
                'e_wallet' => 'required|string',
                'nomor_ponsel' => 'required|string',
            ]);
        }

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $biaya_admin = 2500; // Biaya admin tetap
            $total_transfer = $request->jumlah_transfer + $biaya_admin;

            // Cek apakah poin mencukupi
            if ($user->poin_terkumpul < $total_transfer) {
                return back()->with('error', 'Poin tidak mencukupi untuk melakukan transfer');
            }

            // Buat record transfer baru
            $transfer = TransaksiTransfer::create([
                'user_id' => $user->id,
                'jenis_transfer' => $request->jenis_transfer,
                'bank' => $request->bank ?? null,
                'e_wallet' => $request->e_wallet ?? null,
                'nama_penerima' => $request->nama_penerima,
                'nomor_rekening' => $request->nomor_rekening ?? null,
                'nomor_ponsel' => $request->nomor_ponsel ?? null,
                'jumlah_transfer' => $request->jumlah_transfer,
                'biaya_admin' => $biaya_admin,
                'total_transfer' => $total_transfer,
                'status' => 'pending',
                'catatan' => $request->catatan
            ]);

            // Kurangi poin user
            $user->poin_terkumpul -= $total_transfer;
            $user->save();

            DB::commit();

            return redirect()->route('transfer.index')->with('success', 'Transfer berhasil diproses');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses transfer');
        }
    }

    public function show($id)
    {
        $transfer = TransaksiTransfer::where('user_id', Auth::id())
            ->findOrFail($id);
        return view('user.tukar_poin.transfer.show', compact('transfer'));
    }
}