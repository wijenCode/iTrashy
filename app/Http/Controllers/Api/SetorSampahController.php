<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SetorSampahResource;
use App\Http\Resources\SetorSampahCollection;
use App\Models\JenisSampah;
use App\Models\SetorSampah;
use App\Models\SetorItem;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SetorSampahController extends Controller
{
    /**
     * Display a listing of setor sampah.
     * User: hanya melihat setor sampah miliknya
     * Driver: melihat setor sampah yang statusnya menunggu atau yang dia handle
     * Admin: melihat semua setor sampah
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = SetorSampah::with(['setorItems.jenisSampah', 'user', 'driver']);

        // Filter berdasarkan role
        switch ($user->role) {
            case 'user':
                $query->where('user_id', $user->id);
                break;
            case 'driver':
                $query->where(function($q) use ($user) {
                    $q->where('status', SetorSampah::STATUS_MENUNGGU)
                      ->orWhere('driver_id', $user->id);
                });
                break;
            case 'admin':
                // Admin dapat melihat semua
                break;
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
        }

        // Filter berdasarkan status jika ada
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_setor')) {
            $query->whereDate('tanggal_setor', $request->tanggal_setor);
        }

        $setorSampah = $query->orderBy('created_at', 'desc')->paginate(10);

        return new SetorSampahCollection($setorSampah);
    }

    /**
     * Store a newly created setor sampah.
     * Hanya user yang bisa membuat setor sampah
     */
    public function store(Request $request)
    {
        if ($request->user()->role !== 'user') {
            return response()->json([
                'success' => false,
                'message' => 'Only users can create setor sampah'
            ], 403);
        }

        $request->validate([
            'alamat' => 'required|string',
            'tanggal_setor' => 'required|date|after_or_equal:today',
            'waktu_setor' => 'required',
            'items' => 'required|array|min:1',
            'items.*.jenis_sampah_id' => 'required|exists:jenis_sampah,id',
            'items.*.berat' => 'required|numeric|min:0.25'
        ]);

        DB::beginTransaction();
        
        try {
            // Create setor sampah
            $setorSampah = SetorSampah::create([
                'user_id' => $request->user()->id,
                'alamat' => $request->alamat,
                'tanggal_setor' => $request->tanggal_setor,
                'waktu_setor' => $request->waktu_setor,
                'status' => SetorSampah::STATUS_MENUNGGU
            ]);

            // Generate kode kredensial
            $setorSampah->generateKodeKredensial();

            $fee_percentage = 0.20;
            $totalPoin = 0;

            // Create setor items
            foreach ($request->items as $item) {
                $jenisSampah = JenisSampah::find($item['jenis_sampah_id']);
                $poinBeforeFee = $jenisSampah->poin_per_kg * $item['berat'];
                $poinAfterFee = $poinBeforeFee * (1 - $fee_percentage);

                SetorItem::create([
                    'setor_sampah_id' => $setorSampah->id,
                    'jenis_sampah_id' => $item['jenis_sampah_id'],
                    'berat' => $item['berat'],
                    'poin' => round($poinAfterFee)
                ]);

                $totalPoin += $poinAfterFee;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Setor sampah created successfully',
                'data' => new SetorSampahResource($setorSampah->load(['setorItems.jenisSampah', 'user']))
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create setor sampah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified setor sampah.
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $query = SetorSampah::with(['setorItems.jenisSampah', 'user', 'driver']);

        // Filter berdasarkan role
        switch ($user->role) {
            case 'user':
                $query->where('user_id', $user->id);
                break;
            case 'driver':
                $query->where(function($q) use ($user) {
                    $q->where('status', SetorSampah::STATUS_MENUNGGU)
                      ->orWhere('driver_id', $user->id);
                });
                break;
            case 'admin':
                // Admin dapat melihat semua
                break;
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
        }

        $setorSampah = $query->find($id);

        if (!$setorSampah) {
            return response()->json([
                'success' => false,
                'message' => 'Setor sampah not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new SetorSampahResource($setorSampah)
        ]);
    }

    /**
     * Ambil setor sampah (untuk driver)
     */
    public function ambil(Request $request, $id)
    {
        if ($request->user()->role !== 'driver') {
            return response()->json([
                'success' => false,
                'message' => 'Only drivers can take setor sampah'
            ], 403);
        }

        $setorSampah = SetorSampah::find($id);

        if (!$setorSampah) {
            return response()->json([
                'success' => false,
                'message' => 'Setor sampah not found'
            ], 404);
        }

        if ($setorSampah->status !== SetorSampah::STATUS_MENUNGGU) {
            return response()->json([
                'success' => false,
                'message' => 'Setor sampah is not available for pickup'
            ], 400);
        }

        $setorSampah->update([
            'driver_id' => $request->user()->id,
            'status' => SetorSampah::STATUS_DIKONFIRMASI,
            'tanggal_diambil' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Setor sampah taken successfully',
            'data' => new SetorSampahResource($setorSampah->load(['setorItems.jenisSampah', 'user', 'driver']))
        ]);
    }

    /**
     * Selesaikan setor sampah (untuk driver)
     */
    public function selesai(Request $request, $id)
    {
        if ($request->user()->role !== 'driver') {
            return response()->json([
                'success' => false,
                'message' => 'Only drivers can complete setor sampah'
            ], 403);
        }

        $request->validate([
            'kode_kredensial' => 'required|string|size:6',
            'catatan_driver' => 'nullable|string'
        ]);

        $setorSampah = SetorSampah::where('driver_id', $request->user()->id)
                                 ->where('status', SetorSampah::STATUS_DIKONFIRMASI)
                                 ->find($id);

        if (!$setorSampah) {
            return response()->json([
                'success' => false,
                'message' => 'Setor sampah not found or not assigned to you'
            ], 404);
        }

        if (strtoupper($request->kode_kredensial) !== $setorSampah->kode_kredensial) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credential code'
            ], 400);
        }

        DB::beginTransaction();
        
        try {
            // Update status dan catatan
            $setorSampah->update([
                'status' => SetorSampah::STATUS_SELESAI,
                'catatan_driver' => $request->catatan_driver
            ]);

            // Update poin dan sampah terkumpul user
            $user = $setorSampah->user;
            $totalPoin = $setorSampah->total_poin;
            $totalBerat = $setorSampah->total_berat;

            $user->increment('poin_terkumpul', $totalPoin);
            $user->increment('sampah_terkumpul', $totalBerat);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Setor sampah completed successfully',
                'data' => new SetorSampahResource($setorSampah->load(['setorItems.jenisSampah', 'user', 'driver']))
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete setor sampah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tolak setor sampah (untuk driver atau admin)
     */
    public function tolak(Request $request, $id)
    {
        if (!in_array($request->user()->role, ['driver', 'admin'])) {
            return response()->json([
                'success' => false,
                'message' => 'Only drivers and admins can reject setor sampah'
            ], 403);
        }

        $request->validate([
            'catatan_driver' => 'required|string'
        ]);

        $setorSampah = SetorSampah::find($id);

        if (!$setorSampah) {
            return response()->json([
                'success' => false,
                'message' => 'Setor sampah not found'
            ], 404);
        }

        if ($setorSampah->status === SetorSampah::STATUS_SELESAI) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot reject completed setor sampah'
            ], 400);
        }

        $setorSampah->update([
            'status' => SetorSampah::STATUS_DITOLAK,
            'catatan_driver' => $request->catatan_driver,
            'driver_id' => $request->user()->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Setor sampah rejected successfully',
            'data' => new SetorSampahResource($setorSampah->load(['setorItems.jenisSampah', 'user', 'driver']))
        ]);
    }

    /**
     * Update setor sampah (hanya untuk user dan hanya jika status masih menunggu)
     */
    public function update(Request $request, $id)
    {
        $setorSampah = SetorSampah::find($id);

        if (!$setorSampah) {
            return response()->json([
                'success' => false,
                'message' => 'Setor sampah not found'
            ], 404);
        }

        // Hanya user pemilik yang bisa update
        if ($request->user()->role !== 'user' || $setorSampah->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this setor sampah'
            ], 403);
        }

        // Hanya bisa update jika status masih menunggu
        if ($setorSampah->status !== SetorSampah::STATUS_MENUNGGU) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot update setor sampah that is already processed'
            ], 400);
        }

        $request->validate([
            'alamat' => 'sometimes|required|string',
            'tanggal_setor' => 'sometimes|required|date|after_or_equal:today',
            'waktu_setor' => 'sometimes|required',
            'items' => 'sometimes|required|array|min:1',
            'items.*.jenis_sampah_id' => 'required|exists:jenis_sampah,id',
            'items.*.berat' => 'required|numeric|min:0.25'
        ]);

        DB::beginTransaction();
        
        try {
            // Update setor sampah data
            $setorSampah->update($request->only(['alamat', 'tanggal_setor', 'waktu_setor']));

            // Update items jika ada
            if ($request->has('items')) {
                // Hapus items lama
                $setorSampah->setorItems()->delete();

                $fee_percentage = 0.20;

                // Buat items baru
                foreach ($request->items as $item) {
                    $jenisSampah = JenisSampah::find($item['jenis_sampah_id']);
                    $poinBeforeFee = $jenisSampah->poin_per_kg * $item['berat'];
                    $poinAfterFee = $poinBeforeFee * (1 - $fee_percentage);

                    SetorItem::create([
                        'setor_sampah_id' => $setorSampah->id,
                        'jenis_sampah_id' => $item['jenis_sampah_id'],
                        'berat' => $item['berat'],
                        'poin' => round($poinAfterFee)
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Setor sampah updated successfully',
                'data' => new SetorSampahResource($setorSampah->load(['setorItems.jenisSampah', 'user', 'driver']))
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update setor sampah: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove setor sampah (hanya untuk user dan admin)
     */
    public function destroy(Request $request, $id)
    {
        $setorSampah = SetorSampah::find($id);

        if (!$setorSampah) {
            return response()->json([
                'success' => false,
                'message' => 'Setor sampah not found'
            ], 404);
        }

        // User hanya bisa hapus miliknya sendiri, admin bisa hapus semua
        if ($request->user()->role === 'user' && $setorSampah->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this setor sampah'
            ], 403);
        }

        if (!in_array($request->user()->role, ['user', 'admin'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete setor sampah'
            ], 403);
        }

        // Hanya bisa hapus jika status masih menunggu
        if ($setorSampah->status !== SetorSampah::STATUS_MENUNGGU) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete setor sampah that is already processed'
            ], 400);
        }

        $setorSampah->delete();

        return response()->json([
            'success' => true,
            'message' => 'Setor sampah deleted successfully'
        ]);
    }

    /**
     * Get available jenis sampah
     */
    public function getJenisSampah()
    {
        $jenisSampah = JenisSampah::select('id', 'nama_sampah', 'poin_per_kg', 'kategori_sampah')->get();

        return response()->json([
            'success' => true,
            'data' => $jenisSampah
        ]);
    }
}