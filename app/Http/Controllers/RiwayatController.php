<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TransaksiVoucher;
use App\Models\TransaksiSembako;
use App\Models\TransaksiTransfer;
use App\Models\SetorSampah;
use App\Models\TransaksiDonasi;
use Illuminate\Support\Collection;

class RiwayatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $riwayat = collect();

        // Voucher
        $voucher = TransaksiVoucher::with('voucher')
            ->where('user_id', $user->id)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Voucher',
                    'name' => $item->voucher->nama_voucher ?? '-',
                    'date' => $item->tanggal_transaksi,
                    'poin' => $item->voucher->poin ?? 0,
                    'desc' => 'Penukaran voucher',
                    'kode' => $item->kode_voucher ?? null,
                ];
            });
        // Sembako
        $sembako = TransaksiSembako::with('sembako')
            ->where('user_id', $user->id)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Sembako',
                    'name' => $item->sembako->nama_sembako ?? '-',
                    'date' => $item->tanggal_transaksi,
                    'poin' => $item->sembako->poin ?? 0,
                    'desc' => 'Penukaran sembako',
                    'kode' => null,
                ];
            });
        // Transfer
        $transfer = TransaksiTransfer::where('user_id', $user->id)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Transfer',
                    'name' => $item->jenis_transfer,
                    'date' => $item->created_at,
                    'poin' => $item->jumlah_transfer,
                    'desc' => 'Transfer ke ' . ($item->nama_penerima ?? '-'),
                    'kode' => null,
                ];
            });
        // Setor Sampah
        $setor = SetorSampah::where('user_id', $user->id)
            ->where('status', 'selesai')
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Setor Sampah',
                    'name' => $item->alamat,
                    'date' => $item->tanggal_setor,
                    'poin' => $item->setorItem->sum('poin'),
                    'desc' => 'Setor sampah',
                    'kode' => null,
                ];
            });
        // Donasi
        $donasi = TransaksiDonasi::with('donasi')
            ->where('user_id', $user->id)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Donasi',
                    'name' => $item->donasi->nama_donasi ?? '-',
                    'date' => $item->tanggal_transaksi,
                    'poin' => $item->donasi->donasi_terkumpul ?? 0,
                    'desc' => 'Donasi',
                    'kode' => null,
                ];
            });

        $riwayat = $riwayat->concat($voucher)
            ->concat($sembako)
            ->concat($transfer)
            ->concat($setor)
            ->concat($donasi)
            ->sortByDesc('date')
            ->values();

        return view('user.riwayat.index', compact('riwayat'));
    }
} 