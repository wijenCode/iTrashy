<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SetorSampah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\CreatesNotifications;

class DriverController extends Controller
{
    use CreatesNotifications;

    /**
     * Halaman daftar sampah tersedia untuk diambil
     */
    public function ambilSampah()
    {
        // Ambil semua pesanan dengan status menunggu
        $allSetorSampah = SetorSampah::with(['user', 'setorItems.jenisSampah'])
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Filter pesanan yang sudah ditolak oleh driver ini
        $currentDriverId = Auth::id();
        $setorSampah = $allSetorSampah->filter(function($item) use ($currentDriverId) {
            // Jika tidak ada data penolakan, tampilkan pesanan
            if (empty($item->driver_tolak)) {
                return true;
            }
            
            // Periksa apakah driver ini sudah menolak pesanan ini
            $driverTolak = json_decode($item->driver_tolak, true);
            foreach ($driverTolak as $tolak) {
                if ($tolak['driver_id'] == $currentDriverId) {
                    return false; // Driver ini sudah menolak, jangan tampilkan
                }
            }
            
            return true; // Driver ini belum menolak, tampilkan
        });

        return view('driver.ambil_sampah', compact('setorSampah'));
    }

    /**
     * Terima pesanan setor sampah
     */
    public function terimaPesanan(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $setorSampah = SetorSampah::findOrFail($id);
            
            // Cek apakah masih tersedia
            if ($setorSampah->status !== 'menunggu') {
                return redirect()->back()->with('error', 'Pesanan sudah diambil driver lain.');
            }

            // Update status dan assign driver
            $setorSampah->driver_id = Auth::id();
            $setorSampah->status = 'dikonfirmasi'; // Menggunakan string 'dikonfirmasi' sesuai enum di database
            $setorSampah->tanggal_diambil = now();
            // TIDAK perlu generate kode kredensial di sini karena sudah di-generate saat user membuat pesanan
            $setorSampah->save();

            // Kirim notifikasi ke user
            $this->notifySetorSampahDiterima($setorSampah->user_id, $setorSampah->id);

            DB::commit();

            return redirect()->route('driver.penjemputan.saya')->with('success', 'Pesanan berhasil diterima!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tolak pesanan setor sampah
     */
    public function tolakPesanan(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|max:255'
        ]);

        try {
            DB::beginTransaction();
            
            $setorSampah = SetorSampah::findOrFail($id);
            
            // Cek apakah masih tersedia
            if ($setorSampah->status !== 'menunggu') {
                return redirect()->back()->with('error', 'Pesanan sudah diambil driver lain.');
            }

            // Daripada mengubah status menjadi 'ditolak', kita catat driver yang menolak
            // dan alasannya, tapi tetap biarkan status 'menunggu' agar driver lain bisa mengambil
            
            // Simpan data penolakan di tabel terpisah atau dalam JSON
            // Jika belum ada kolom driver_tolak, kita gunakan array kosong
            $driverTolak = json_decode($setorSampah->driver_tolak ?? '[]', true);
            $driverTolak[] = [
                'driver_id' => Auth::id(),
                'alasan' => $request->alasan,
                'waktu' => now()->toDateTimeString()
            ];
            
            // Simpan kembali ke database
            $setorSampah->driver_tolak = json_encode($driverTolak);
            $setorSampah->save();

            // Kirim notifikasi ke user
            $this->notifySetorSampahDitolak($setorSampah->user_id, $setorSampah->id, $request->alasan);

            DB::commit();

            return redirect()->back()->with('success', 'Anda telah menolak pesanan ini. Pesanan masih tersedia untuk driver lain.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Halaman penjemputan saya (pesanan yang sudah diambil)
     */
    public function penjemputanSaya()
    {
        $setorSampah = SetorSampah::with(['user', 'setorItems.jenisSampah'])
            ->where('driver_id', Auth::id())
            ->where('status', 'dikonfirmasi') // Menggunakan string 'dikonfirmasi' sesuai enum di database
            ->orderBy('tanggal_diambil', 'desc')
            ->get();

        return view('driver.penjemputan_saya', compact('setorSampah'));
    }

    /**
     * Edit data penjemputan (memerlukan kode kredensial dari user)
     */
    public function editPenjemputan(Request $request, $id)
    {
        $request->validate([
            'kode_kredensial' => 'required|string',
            'sampah_berat' => 'required|array',
            'sampah_berat.*' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $setorSampah = SetorSampah::with('setorItems.jenisSampah')->findOrFail($id);
            
            // Cek apakah driver yang benar
            if ($setorSampah->driver_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pesanan ini.');
            }

            // Cek kode kredensial yang di-input driver dengan kode yang sudah di-generate user
            if ($setorSampah->kode_kredensial !== strtoupper($request->kode_kredensial)) {
                return redirect()->back()->with('error', 'Kode kredensial salah! Pastikan Anda memasukkan kode yang benar dari pengguna.');
            }

            // Update berat dan hitung ulang poin
            $totalPoinBaru = 0;
            $totalBeratBaru = 0;
            $fee_percentage = 0.20;

            foreach ($setorSampah->setorItems as $index => $item) {
                $beratBaru = $request->sampah_berat[$index];
                
                // Hitung poin baru
                $poinBeforeFee = $item->jenisSampah->poin_per_kg * $beratBaru;
                $fee = $poinBeforeFee * $fee_percentage;
                $poinAfterFee = $poinBeforeFee - $fee;
                
                // Update item
                $item->berat = $beratBaru;
                $item->poin = round($poinAfterFee);
                $item->save();
                
                $totalPoinBaru += round($poinAfterFee);
                $totalBeratBaru += $beratBaru;
            }

            // TIDAK perlu update poin user di sini karena akan diupdate saat selesaikan penjemputan

            DB::commit();

            return redirect()->back()->with('success', 'Data penjemputan berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Selesaikan penjemputan
     */
    public function selesaikanPenjemputan($id)
    {
        try {
            DB::beginTransaction();

            $setorSampah = SetorSampah::with('setorItems')->findOrFail($id);
            
            // Cek apakah driver yang benar
            if ($setorSampah->driver_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pesanan ini.');
            }

            // Update status
            $setorSampah->status = 'selesai';
            $setorSampah->save();

            // Update poin dan sampah terkumpul user
            $user = $setorSampah->user;
            $totalPoin = $setorSampah->setorItems->sum('poin');
            $totalBerat = $setorSampah->setorItems->sum('berat');
            
            $user->poin_terkumpul = ($user->poin_terkumpul ?? 0) + $totalPoin;
            $user->sampah_terkumpul = ($user->sampah_terkumpul ?? 0) + $totalBerat;
            $user->save();

            // Kirim notifikasi ke user
            $this->notifySetorSampahSelesai($setorSampah->user_id, $setorSampah->id, $totalPoin);

            DB::commit();

            return redirect()->back()->with('success', 'Penjemputan berhasil diselesaikan! Poin user telah diupdate.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
 }
}

    public function showSetorSampahDetail($id)
    {
        $setorSampah = SetorSampah::with(['user', 'setorItems.jenisSampah'])
            ->findOrFail($id);

        // Pastikan driver hanya bisa melihat detail pesanan yang statusnya menunggu atau yang dia handle
        if ($setorSampah->status !== SetorSampah::STATUS_MENUNGGU && $setorSampah->driver_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke detail pesanan ini.');
        }

        return view('driver.setor_sampah_detail', compact('setorSampah'));
    }
}
