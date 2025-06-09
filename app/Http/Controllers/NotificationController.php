<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        try {
            $notifications = auth()->user()->notifications()
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($notifications);
        } catch (\Exception $e) {
            Log::error('Error fetching notifications: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch notifications'], 500);
        }
    }

    public function markAsRead($id)
    {
        try {
            DB::beginTransaction();
            
            $notification = auth()->user()->notifications()->findOrFail($id);
            $notification->update(['is_read' => true]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error marking notification as read: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notification as read'
            ], 500);
        }
    }

    public function markAllAsRead()
    {
        try {
            DB::beginTransaction();
            
            $updated = auth()->user()->notifications()
                ->where('is_read', false)
                ->update(['is_read' => true]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read',
                'count' => $updated
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error marking all notifications as read: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark all notifications as read'
            ], 500);
        }
    }

    public function getUnreadCount()
    {
        try {
            $count = auth()->user()->notifications()
                ->where('is_read', false)
                ->count();
                
            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            Log::error('Error getting unread count: ' . $e->getMessage());
            return response()->json(['count' => 0]);
        }
    }

    public function notifySetorSampahDiterima($userId, $setorId)
    {
        try {
            DB::beginTransaction();
            
            $notification = Notification::create([
                'user_id' => $userId,
                'title' => 'Setor Sampah Diterima',
                'message' => 'Setoran sampah kamu sudah diterima dan sedang diproses.',
                'type' => 'info',
                'link' => "/user/setor-sampah/{$setorId}"
            ]);
            
            DB::commit();
            return $notification;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create notification: ' . $e->getMessage());
            return null;
        }
    }

    public function notifySetorSampahDitolak($userId, $setorId, $alasan)
    {
        try {
            DB::beginTransaction();
            
            $notification = Notification::create([
                'user_id' => $userId,
                'title' => 'Setor Sampah Ditolak',
                'message' => "Setoran sampah kamu ditolak dengan alasan: {$alasan}",
                'type' => 'error',
                'link' => "/user/setor-sampah/{$setorId}"
            ]);
            
            DB::commit();
            return $notification;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create notification: ' . $e->getMessage());
            return null;
        }
    }

    public function notifySetorSampahSelesai($userId, $setorId, $totalPoin)
    {
        try {
            DB::beginTransaction();
            
            $notification = Notification::create([
                'user_id' => $userId,
                'title' => 'Setor Sampah Selesai',
                'message' => "Setoran sampah kamu sudah selesai diproses. Kamu mendapatkan {$totalPoin} poin!",
                'type' => 'success',
                'link' => "/user/setor-sampah/{$setorId}"
            ]);
            
            DB::commit();
            return $notification;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create notification: ' . $e->getMessage());
            return null;
        }
    }
} 