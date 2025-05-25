<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiTransfer;
use App\Models\User;
use App\Models\TransferDetail;
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

        // Check if user has enough points for minimal transfer
        $hasEnoughPoints = ($poin_terkumpul >= 25000);

        // Fetch recent transfer history for the user
        // Only fetch if user has enough points, or maybe fetch anyway and indicate in view
        // Let's fetch anyway to show history even if they can't transfer
        $riwayat_transfer = TransaksiTransfer::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5) // Ambil 5 transfer terakhir
            ->get();

        // Fetch recent transfer details for the 'Transfer Lagi' section from the 'transfer' table
        $recent_transfer_details = \App\Models\TransferDetail::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Return the view with the fetched data and the flag
        return view('user.tukar_poin.transfer.index', compact('poin_terkumpul', 'riwayat_transfer', 'hasEnoughPoints', 'recent_transfer_details'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'jenis_transfer' => 'required|in:bank,e_wallet',
                
                'jumlah_poin' => 'required|numeric|min:25000',
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

            DB::beginTransaction();

            $user = Auth::user();
            $jumlah_poin = $request->jumlah_poin;
            $biaya_admin_rp = $request->jenis_transfer === 'bank' ? 2500 : 1000;
            
            // Konversi poin ke nilai Rupiah sebelum biaya admin
            $jumlah_transfer_rp = $jumlah_poin * 0.50;
            $total_transfer_rp = $jumlah_transfer_rp + $biaya_admin_rp;

            // Cek apakah poin mencukupi
            if ($user->poin_terkumpul < $jumlah_poin) {
                throw new \Exception('Poin tidak mencukupi untuk melakukan transfer. Poin Anda: ' . number_format($user->poin_terkumpul) . ', Poin yang dibutuhkan: ' . number_format($jumlah_poin));
            }

            // Buat record detail transfer di tabel 'transfer'
            $transferDetail = TransferDetail::create([
                'user_id' => $user->id,
                'e_wallet' => $request->e_wallet ?? null,
                'no_telepon' => $request->nomor_ponsel ?? null,
                'bank' => $request->bank ?? null,
                'poin_ditukar' => $jumlah_poin,
                'jumlah_transfer' => $jumlah_transfer_rp,
                'admin_fee' => $biaya_admin_rp,
                'total_transfer' => $total_transfer_rp,
            ]);

            // Buat record log transaksi umum di tabel 'transaksi_transfer'
            TransaksiTransfer::create([
                'user_id' => $user->id,
                'transfer_id' => $transferDetail->id,
                'tanggal_transaksi' => now(),
                'status' => 'berhasil',
            ]);

            // Kurangi poin user
            $user->poin_terkumpul -= $jumlah_poin;
            $user->save();

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Transfer berhasil! Poin Anda telah berkurang dan transaksi masuk ke riwayat.'
                ]);
            }

            return redirect()->route('transfer.index')->with('success', 'Transfer berhasil! Poin Anda telah berkurang dan transaksi masuk ke riwayat.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Transfer failed: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }

            return back()->with('error', 'Terjadi kesalahan saat memproses transfer: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $transfer = TransaksiTransfer::where('user_id', Auth::id())
            ->findOrFail($id);
        return view('user.tukar_poin.transfer.show', compact('transfer'));
    }

    public function detail(Request $request)
    {
        $jenis = $request->input('jenis');
        // Ambil nama bank sebagai string dari request
        $bank_name = $request->input('bank', '-');
        $ewallet = $request->input('e_wallet', '-');
        $nomor_rekening = $request->input('nomor_rekening', '-');
        $nomor_ponsel = $request->input('nomor_ponsel', '-');
        $nama_penerima = $request->input('nama_penerima', '-');
        $jumlah_poin = (int) $request->input('jumlah_poin', 0);
        $catatan = $request->input('catatan', '');
        
        $biaya_admin = $jenis === 'bank' ? 2500 : 1000;
        $nominal = $jumlah_poin * 0.50;
        $total = $nominal + $biaya_admin;

        $user = \Auth::user();
        if ($user->poin_terkumpul < $jumlah_poin) {
            return redirect()->route('transfer.index')->with('error', 'Poin Anda tidak mencukupi untuk melakukan transfer ini. Silakan setor sampah atau tukar poin terlebih dahulu!');
        }

        // Pastikan variabel bank adalah string nama bank saat dikirim ke view
        $bank_for_view = $jenis === 'bank' ? $bank_name : $bank_name; // Jika jenisnya bank, gunakan nama bank. Jika bukan, tetap '-' atau nilai dari request.
        
        return view('user.tukar_poin.transfer.detail', compact(
            'jenis', 'bank_for_view', 'ewallet', 'nomor_rekening', 'nomor_ponsel', 'nama_penerima', 'nominal', 'catatan', 'biaya_admin', 'total', 'jumlah_poin'
        ));
    }
}