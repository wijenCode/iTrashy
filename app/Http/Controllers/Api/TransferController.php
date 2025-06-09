<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Transfer;
use App\Models\User;
use App\Traits\CreatesNotifications;

class TransferController extends Controller
{
    use CreatesNotifications;

    public function transferPoin(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'jenis' => 'required|in:bank,e_wallet',
            'jumlah_poin' => 'required|integer|min:25000',
            'catatan' => 'nullable|string|max:255',
        ]);

        if ($user->poin_terkumpul < $request->jumlah_poin) {
            return response()->json(['message' => 'Poin tidak mencukupi untuk melakukan transfer.', 'success' => false], 400);
        }

        DB::beginTransaction();

        try {
            $biayaAdmin = 0;
            $nomorTujuan = '';
            $namaTujuan = '';

            if ($request->jenis === 'bank') {
                $request->validate([
                    'bank' => 'required|string',
                    'nomor_rekening' => 'required|string|numeric',
                ]);
                $biayaAdmin = 2500; // Biaya admin bank
                $nomorTujuan = $request->nomor_rekening;
                $namaTujuan = $request->bank;
            } else { // e_wallet
                $request->validate([
                    'e_wallet' => 'required|string',
                    'no_telepon' => 'required|string|numeric',
                ]);
                $biayaAdmin = 1000; // Biaya admin e-wallet
                $nomorTujuan = $request->no_telepon;
                $namaTujuan = $request->e_wallet;
            }

            $poinDitukar = $request->jumlah_poin;
            $jumlahTransferRupiah = $poinDitukar * 0.50; // 1 poin = Rp 0.50
            $totalDiterima = $jumlahTransferRupiah - $biayaAdmin;

            if ($totalDiterima < 0) {
                DB::rollBack();
                return response()->json(['message' => 'Jumlah transfer tidak valid setelah dikurangi biaya admin.', 'success' => false], 400);
            }

            // Catat transaksi transfer
            $transfer = Transfer::create([
                'user_id' => $user->id,
                'e_wallet' => ($request->jenis === 'e_wallet') ? $request->e_wallet : null,
                'no_telepon' => ($request->jenis === 'e_wallet') ? $request->no_telepon : null,
                'bank' => ($request->jenis === 'bank') ? $request->bank : null,
                'poin_ditukar' => $poinDitukar,
                'jumlah_transfer' => $jumlahTransferRupiah, // Nilai rupiah sebelum admin fee
                'admin_fee' => $biayaAdmin,
                'total_transfer' => $totalDiterima, // Nilai rupiah setelah admin fee (yang diterima user)
            ]);

            // Kurangi poin user
            $user->decrement('poin_terkumpul', $poinDitukar);

            DB::commit();

            // Kirim notifikasi sukses ke user
            $message = "Transfer {$poinDitukar} poin ke {$namaTujuan} ({$nomorTujuan}) berhasil! Total diterima: Rp " . number_format($totalDiterima, 0, ',', '.') . ".";
            $this->createNotification(
                $user->id,
                'Transfer Poin Berhasil',
                $message,
                'success',
                route('riwayat.index')
            );

            return response()->json(['message' => 'Transfer poin berhasil!', 'success' => true, 'data' => $transfer]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['message' => $e->errors(), 'success' => false], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during poin transfer: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan saat transfer poin.', 'success' => false], 500);
        }
    }
}
