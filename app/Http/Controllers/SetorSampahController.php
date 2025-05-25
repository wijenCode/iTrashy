<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSampah;
use App\Models\SetorSampah;
use App\Models\SetorItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SetorSampahController extends Controller
{
    /**
     * Display the setor sampah form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenis_sampah = JenisSampah::all();
        return view('user.setor_sampah.index', compact('jenis_sampah'));
    }

    /**
     * Store a newly created setor sampah in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'alamat' => 'required|string',
            'tanggal_setor' => 'required|date',
            'waktu_setor' => 'required',
            'sampah_id' => 'required|array',
            'sampah_id.*' => 'required|exists:jenis_sampah,id',
            'sampah_berat' => 'required|array',
            'sampah_berat.*' => 'required|numeric|min:0.25',
            'sampah_poin' => 'required|array',
            'sampah_poin.*' => 'required|numeric'
        ]);

        // Begin database transaction
        DB::beginTransaction();
        
        try {
            // Create the setor_sampah record
            $setorSampah = new SetorSampah();
            $setorSampah->user_id = Auth::id();
            $setorSampah->alamat = $request->alamat;
            $setorSampah->tanggal_setor = $request->tanggal_setor;
            $setorSampah->waktu_setor = $request->waktu_setor;
            $setorSampah->status = SetorSampah::STATUS_MENUNGGU;
            
            // Generate kode kredensial saat user membuat pesanan
            $setorSampah->generateKodeKredensial();
            $setorSampah->save();

            // Define fee (20%)
            $fee_percentage = 0.20;
            $totalPoinBeforeFee = 0;
            $totalSampah = 0;

            // Create setor_item records for each item
            foreach ($request->sampah_id as $index => $jenis_sampah_id) {
                $berat = $request->sampah_berat[$index];
                $jenisSampah = JenisSampah::find($jenis_sampah_id);
                
                // Calculate points (before fee)
                $poinBeforeFee = $jenisSampah->poin_per_kg * $berat;
                $fee = $poinBeforeFee * $fee_percentage;
                $poinAfterFee = $poinBeforeFee - $fee;
                
                $setorItem = new SetorItem();
                $setorItem->setor_sampah_id = $setorSampah->id;
                $setorItem->jenis_sampah_id = $jenis_sampah_id;
                $setorItem->berat = $berat;
                $setorItem->poin = round($poinAfterFee); // Save points after fee
                $setorItem->save();
                
                $totalPoinBeforeFee += $poinBeforeFee;
                $totalSampah += $berat;
            }

            // Calculate total fee and points after fee
            $totalFee = $totalPoinBeforeFee * $fee_percentage;
            $totalPoinAfterFee = $totalPoinBeforeFee - $totalFee;

            // Jangan update poin user dulu, tunggu sampai selesai
            // Poin akan diupdate saat driver menyelesaikan penjemputan

            DB::commit();

            return redirect()->route('setor.sampah.detail', $setorSampah->id)->with('success', 
                'Permintaan setor sampah berhasil dikirim! Kode kredensial Anda: <strong>' . $setorSampah->kode_kredensial . '</strong><br>Simpan kode ini untuk diberikan kepada driver saat penjemputan.'
            );

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show detail setor sampah untuk user
     */
    public function show($id)
    {
        $setorSampah = SetorSampah::with(['setorItems.jenisSampah', 'driver'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.setor_sampah.detail', compact('setorSampah'));
    }

    /**
     * Show history setor sampah user
     */
    public function history()
    {
        $setorSampah = SetorSampah::with(['setorItems.jenisSampah', 'driver'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.setor_sampah.history', compact('setorSampah'));
    }
}