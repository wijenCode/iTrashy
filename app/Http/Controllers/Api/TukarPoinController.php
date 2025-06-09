<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Voucher;
use App\Models\Sembako;
use App\Models\TransaksiVoucher;
use App\Models\TransaksiSembako;
use App\Traits\CreatesNotifications;

class TukarPoinController extends Controller
{
    use CreatesNotifications;

    public function index()
    {
        $vouchers = Voucher::where('status', 'tersedia')->get();
        $sembakos = Sembako::where('status', 'tersedia')->get();
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'poin_terkumpul' => $user->poin_terkumpul ?? 0,
            'vouchers' => $vouchers,
            'sembakos' => $sembakos,
        ]);
    }

    public function tukarVoucher(Request $request, $id)
    {
        $user = Auth::user();
        $voucher = Voucher::find($id);

        if (!$voucher || $voucher->status !== 'tersedia') {
            return response()->json(['message' => 'Voucher tidak ditemukan atau tidak tersedia.', 'success' => false], 404);
        }

        if ($user->poin_terkumpul < $voucher->poin) {
            return response()->json(['message' => 'Poin Anda tidak mencukupi untuk menukar voucher ini.', 'success' => false], 400);
        }

        DB::beginTransaction();

        try {
            // Kurangi poin user
            $user->decrement('poin_terkumpul', $voucher->poin);

            // Simpan transaksi
            TransaksiVoucher::create([
                'user_id' => $user->id,
                'voucher_id' => $voucher->id,
                'tanggal_transaksi' => now(),
                'status' => 'berhasil',
            ]);

            // (Opsional) Kurangi jumlah voucher jika ada stok
            if (isset($voucher->jumlah_voucher) && $voucher->jumlah_voucher > 0) {
                $voucher->decrement('jumlah_voucher');
            }

            DB::commit();

            // Kirim notifikasi sukses ke user
            $message = "Penukaran voucher '{$voucher->nama_voucher}' sebesar {$voucher->poin} poin berhasil!";
            $this->createNotification(
                $user->id,
                'Penukaran Voucher Berhasil',
                $message,
                'success',
                route('riwayat.index') // Atau rute yang lebih spesifik jika ada
            );

            return response()->json(['message' => 'Penukaran voucher berhasil!', 'success' => true, 'data' => $voucher]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during voucher redemption: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan saat menukar voucher.', 'success' => false], 500);
        }
    }

    public function tukarSembako(Request $request, $id)
    {
        $user = Auth::user();
        $sembako = Sembako::find($id);

        if (!$sembako || $sembako->status !== 'tersedia') {
            return response()->json(['message' => 'Sembako tidak ditemukan atau tidak tersedia.', 'success' => false], 404);
        }

        if ($user->poin_terkumpul < $sembako->poin) {
            return response()->json(['message' => 'Poin Anda tidak mencukupi untuk menukar sembako ini.', 'success' => false], 400);
        }

        DB::beginTransaction();

        try {
            // Kurangi poin user
            $user->decrement('poin_terkumpul', $sembako->poin);

            // Simpan transaksi
            TransaksiSembako::create([
                'user_id' => $user->id,
                'sembako_id' => $sembako->id,
                'tanggal_transaksi' => now(),
                'status' => 'berhasil',
            ]);

            // (Opsional) Kurangi jumlah barang jika ada stok
            if (isset($sembako->jumlah_barang) && $sembako->jumlah_barang > 0) {
                $sembako->decrement('jumlah_barang');
            }

            DB::commit();

            // Kirim notifikasi sukses ke user
            $message = "Penukaran sembako '{$sembako->nama_sembako}' sebesar {$sembako->poin} poin berhasil!";
            $this->createNotification(
                $user->id,
                'Penukaran Sembako Berhasil',
                $message,
                'success',
                route('riwayat.index') // Atau rute yang lebih spesifik jika ada
            );

            return response()->json(['message' => 'Penukaran sembako berhasil!', 'success' => true, 'data' => $sembako]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during sembako redemption: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan saat menukar sembako.', 'success' => false], 500);
        }
    }
} 