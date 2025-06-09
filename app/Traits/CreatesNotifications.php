<?php

namespace App\Traits;

use App\Models\Notification;

trait CreatesNotifications
{
    protected function createNotification($userId, $title, $message, $type = 'info', $link = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'link' => $link
        ]);
    }

    protected function notifySetorSampahDiterima($userId, $setorId)
    {
        return $this->createNotification(
            $userId,
            'Setor Sampah Diterima',
            'Setoran sampah kamu sudah diterima dan sedang diproses.',
            'info',
            route('riwayat.detail', $setorId)
        );
    }

    protected function notifySetorSampahDitolak($userId, $setorId, $alasan)
    {
        return $this->createNotification(
            $userId,
            'Setor Sampah Ditolak',
            "Setoran sampah kamu ditolak dengan alasan: {$alasan}",
            'error',
            route('riwayat.detail', $setorId)
        );
    }

    protected function notifySetorSampahSelesai($userId, $setorId, $totalPoin)
    {
        return $this->createNotification(
            $userId,
            'Setor Sampah Selesai',
            "Setoran sampah kamu sudah selesai diproses. Kamu mendapatkan {$totalPoin} poin!",
            'success',
            route('riwayat.detail', $setorId)
        );
    }

    protected function notifyNewSetorSampahForDriver($driverId, $userName, $userAddress, $setorId)
    {
        return $this->createNotification(
            $driverId,
            'Setoran Sampah Baru!',
            "Ada setoran sampah baru dari {$userName} di {$userAddress}. Segera cek untuk mengambilnya.",
            'info',
            route('driver.ambil.sampah')
        );
    }
} 