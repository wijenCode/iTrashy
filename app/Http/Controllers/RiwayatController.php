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
use App\Models\SetorItem;

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
                    'status' => $item->status ?? 'berhasil',
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
                    'status' => $item->status ?? 'berhasil',
                ];
            });
        // Transfer
        $transfer = TransaksiTransfer::with('transferDetail')
            ->where('user_id', $user->id)
            ->get()
            ->map(function($item) {
                $transferDetail = $item->transferDetail;
                
                return [
                    'type' => 'Transfer',
                    'name' => $transferDetail ? ($transferDetail->bank ?? $transferDetail->e_wallet ?? 'Transfer') : '-',
                    'date' => $item->tanggal_transaksi,
                    'poin' => $transferDetail ? $transferDetail->poin_ditukar : 0,
                    'desc' => 'Transfer ke ' . ($transferDetail ? ($transferDetail->bank ?? $transferDetail->e_wallet) : '-'),
                    'kode' => null,
                    'status' => $item->status ?? 'berhasil',
                ];
            });
        // Setor Sampah
        $setor = SetorSampah::where('user_id', $user->id)
            ->where('status', 'selesai')
            ->get()
            ->map(function($items) {
                return [
                    'id' => $items->id,
                    'type' => 'Setor Sampah',
                    'name' => $items->alamat,
                    'date' => $items->tanggal_setor,
                    'poin' => $items->setorItems->sum('poin'),
                    'desc' => 'Setor sampah',
                    'kode' => null,
                    'status' => $item->status ?? 'selesai',
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
                    'status' => $item->status ?? 'berhasil',
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