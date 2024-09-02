<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user.
     * 
     *
     * @return JsonResponse
     */
    public function getAllNotifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications;

        return response()->json(['notifications' => $notifications], 200);
    }

    /**
     * Mark a notification as read.
     *
     * @param int $notificationId
     * @return JsonResponse
     */
    public function markNotificationAsRead($notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'Notification marked as read.'], 200);
        }

        return response()->json(['message' => 'Notification not found.'], 404);
    }

    /**
     * Get unread notifications for the authenticated user.
     *
     * @return JsonResponse
     */
    public function getUnreadNotifications()
    {
        $user = Auth::user();
        $unreadNotifications = $user->unreadNotifications;

        return response()->json(['notifications' => $unreadNotifications], 200);
    }
}
