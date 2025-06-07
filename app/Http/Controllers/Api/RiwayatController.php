<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SetorSampah;
use App\Models\TransaksiTransfer;
use App\Models\TransaksiVoucher;
use App\Models\TransaksiDonasi;
use App\Models\TransaksiSembako;
use App\Models\SetorItem;
use App\Models\JenisSampah;
use App\Models\TransferDetail;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    /**
     * Get all transaction history with filters
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $type = $request->get('type', 'Semua');
        $status = $request->get('status', 'Semua');
        $search = $request->get('search', '');
        $perPage = $request->get('per_page', 10);

        $riwayat = collect();

        // Get Setor Sampah history
        if ($type === 'Semua' || $type === 'Setor Sampah') {
            $setorSampah = SetorSampah::where('user_id', $user->id)
                ->with(['setorItems.jenisSampah']) // Eager load setorItems and their JenisSampah
                ->when($status !== 'Semua', function($query) use ($status) {
                    $query->where('status', $status);
                })
                ->when($search, function($query) use ($search) {
                    // Search on alamat or catatan_driver
                    $query->where(function($q) use ($search) {
                        $q->where('alamat', 'like', "%{$search}%")
                          ->orWhere('catatan_driver', 'like', "%{$search}%");
                    });
                })
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'Setor Sampah',
                        'status' => $item->status,
                        'poin' => $item->getTotalPoinAttribute(), // Use accessor for total poin
                        'date' => $item->created_at,
                        'desc' => $item->alamat, // Using alamat as description for now
                        'jenis_sampah' => $item->setorItems->map(fn($si) => $si->jenisSampah->nama_jenis)->implode(', '),
                        'berat' => $item->getTotalBeratAttribute(), // Use accessor for total berat
                        'alamat' => $item->alamat
                    ];
                });
            $riwayat = $riwayat->concat($setorSampah);
        }

        // Get Transfer history
        if ($type === 'Semua' || $type === 'Transfer') {
            $transfer = TransaksiTransfer::where('user_id', $user->id)
                ->with('transferDetail') // Eager load transferDetail
                ->when($status !== 'Semua', function($query) use ($status) {
                    $query->where('status', $status);
                })
                ->when($search, function($query) use ($search) {
                    // Search on transferDetail fields
                    $query->whereHas('transferDetail', function($q) use ($search) {
                        $q->where('penerima', 'like', "%{$search}%")
                          ->orWhere('no_telepon', 'like', "%{$search}%");
                    });
                })
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'Transfer',
                        'status' => $item->status,
                        'poin' => $item->transferDetail->poin_ditukar ?? 0, // Assuming poin_ditukar is the points
                        'date' => $item->tanggal_transaksi,
                        'desc' => 'Transfer ke ' . ($item->transferDetail->penerima ?? 'N/A') . ' (' . ($item->transferDetail->no_telepon ?? 'N/A') . ')',
                        'penerima' => $item->transferDetail->penerima ?? null,
                        'nomor_penerima' => $item->transferDetail->no_telepon ?? null
                    ];
                });
            $riwayat = $riwayat->concat($transfer);
        }

        // Get Voucher history
        if ($type === 'Semua' || $type === 'Voucher') {
            $voucher = TransaksiVoucher::where('user_id', $user->id)
                ->with('voucher') // Eager load voucher details
                ->when($status !== 'Semua', function($query) use ($status) {
                    $query->where('status', $status);
                })
                ->when($search, function($query) use ($search) {
                    // Search on voucher fields
                    $query->whereHas('voucher', function($q) use ($search) {
                        $q->where('nama_voucher', 'like', "%{$search}%")
                          ->orWhere('deskripsi', 'like', "%{$search}%");
                    });
                })
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'Voucher',
                        'status' => $item->status,
                        'poin' => $item->voucher->poin ?? 0,
                        'date' => $item->tanggal_transaksi,
                        'desc' => $item->voucher->deskripsi ?? 'Tukar Poin',
                        'kode' => 'VOUCHER-' . substr(md5(uniqid($item->id)), 0, 6), // Placeholder code
                        'jenis_voucher' => $item->voucher->nama_voucher ?? null,
                        'nilai_voucher' => $item->voucher->nilai_voucher ?? null
                    ];
                });
            $riwayat = $riwayat->concat($voucher);
        }

        // Get Sembako history
        if ($type === 'Semua' || $type === 'Sembako') {
            $sembako = TransaksiSembako::where('user_id', $user->id)
                ->with('sembako') // Eager load sembako details
                ->when($status !== 'Semua', function($query) use ($status) {
                    $query->where('status', $status);
                })
                ->when($search, function($query) use ($search) {
                    // Search on sembako fields
                    $query->whereHas('sembako', function($q) use ($search) {
                        $q->where('nama_sembako', 'like', "%{$search}%")
                          ->orWhere('deskripsi', 'like', "%{$search}%");
                    });
                })
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'Sembako',
                        'status' => $item->status,
                        'poin' => $item->sembako->poin ?? 0,
                        'date' => $item->tanggal_transaksi,
                        'desc' => $item->sembako->deskripsi ?? 'Tukar Sembako',
                        'jenis_sembako' => $item->sembako->nama_sembako ?? null,
                        'jumlah' => $item->sembako->jumlah_barang ?? null
                    ];
                });
            $riwayat = $riwayat->concat($sembako);
        }

        // Get Donasi history
        if ($type === 'Semua' || $type === 'Donasi') {
            $donasi = TransaksiDonasi::where('user_id', $user->id)
                ->with('donasi') // Eager load donasi details
                ->when($status !== 'Semua', function($query) use ($status) {
                    $query->where('status', $status);
                })
                ->when($search, function($query) use ($search) {
                    // Search on donasi fields
                    $query->whereHas('donasi', function($q) use ($search) {
                        $q->where('nama_donasi', 'like', "%{$search}%")
                          ->orWhere('deskripsi', 'like', "%{$search}%");
                    });
                })
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'Donasi',
                        'status' => $item->status,
                        'poin' => $item->donasi->jumlah_poin ?? 0, // Assuming donasi->jumlah_poin is the points, or 0 if not found
                        'date' => $item->tanggal_transaksi,
                        'desc' => $item->donasi->deskripsi ?? 'Donasi',
                        'lembaga' => $item->donasi->nama_donasi ?? null,
                        'jenis_donasi' => $item->donasi->nama_donasi ?? null
                    ];
                });
            $riwayat = $riwayat->concat($donasi);
        }

        // Sort by date (all transactions will have 'date' field)
        $riwayat = $riwayat->sortByDesc('date');

        // Manual pagination
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $perPage;
        $paginatedData = $riwayat->slice($offset, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'current_page' => (int)$page,
                'data' => $paginatedData->values(),
                'first_page_url' => url("/api/riwayat?page=1"),
                'from' => $offset + 1,
                'last_page' => ceil($riwayat->count() / $perPage),
                'last_page_url' => url("/api/riwayat?page=" . ceil($riwayat->count() / $perPage)),
                'next_page_url' => $page < ceil($riwayat->count() / $perPage) ? url("/api/riwayat?page=" . ($page + 1)) : null,
                'path' => url("/api/riwayat"),
                'per_page' => (int)$perPage,
                'prev_page_url' => $page > 1 ? url("/api/riwayat?page=" . ($page - 1)) : null,
                'to' => $offset + $paginatedData->count(),
                'total' => $riwayat->count()
            ]
        ]);
    }

    /**
     * Get transaction detail by ID and type
     */
    public function show($type, $id)
    {
        $user = auth()->user();
        $data = null;

        switch ($type) {
            case 'setor-sampah':
                $data = SetorSampah::where('user_id', $user->id)->with('setorItems.jenisSampah')->findOrFail($id);
                $data->poin = $data->getTotalPoinAttribute(); // Add total poin
                $data->berat = $data->getTotalBeratAttribute(); // Add total berat
                break;
            case 'transfer':
                $data = TransaksiTransfer::where('user_id', $user->id)->with('transferDetail')->findOrFail($id);
                break;
            case 'voucher':
                $data = TransaksiVoucher::where('user_id', $user->id)->with('voucher')->findOrFail($id);
                break;
            case 'sembako':
                $data = TransaksiSembako::where('user_id', $user->id)->with('sembako')->findOrFail($id);
                break;
            case 'donasi':
                $data = TransaksiDonasi::where('user_id', $user->id)->with('donasi')->findOrFail($id);
                break;
            default:
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid transaction type'
                ], 400);
        }

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
} 