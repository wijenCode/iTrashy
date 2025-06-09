<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\NotificationResource; // Import NotificationResource

class NotificationController extends Controller
{
    public function index()
    {
        try {
            $notifications = Auth::user()->notifications()
                ->orderBy('created_at', 'desc')
                ->get();

            return NotificationResource::collection($notifications);
        } catch (\Exception $e) {
            Log::error('Error fetching notifications (API): ' . $e->getMessage());
            return response()->json(['message' => 'Failed to fetch notifications'], 500);
        }
    }

    public function markAsRead($id)
    {
        try {
            $notification = Auth::user()->notifications()->findOrFail($id);
            $notification->update(['is_read' => true]);

            return response()->json(['message' => 'Notification marked as read', 'success' => true]);
        } catch (\Exception $e) {
            Log::error('Error marking notification as read (API): ' . $e->getMessage());
            return response()->json(['message' => 'Failed to mark notification as read', 'success' => false], 500);
        }
    }

    public function markAllAsRead()
    {
        try {
            Auth::user()->notifications()
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json(['message' => 'All notifications marked as read', 'success' => true]);
        } catch (\Exception $e) {
            Log::error('Error marking all notifications as read (API): ' . $e->getMessage());
            return response()->json(['message' => 'Failed to mark all notifications as read', 'success' => false], 500);
        }
    }

    public function unreadCount()
    {
        try {
            $count = Auth::user()->notifications()
                ->where('is_read', false)
                ->count();

            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            Log::error('Error getting unread count (API): ' . $e->getMessage());
            return response()->json(['count' => 0]);
        }
    }
} 