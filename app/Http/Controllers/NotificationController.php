<?php
namespace App\Http\Controllers;

use App\Events\Notifications;
use Illuminate\Http\Request;
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
        // Get the authenticated user
        $user = Auth::user();
        
        // Find the notification belonging to the user
        $notification = $user->notifications()->find($notificationId);
    
        // Check if the notification exists
        if ($notification) {
            // Mark the notification as read
            $notification->markAsRead();
    
            // Optionally get the unread notifications count
            // $unreadCount = $user->unreadNotifications->count();
    
            // Optionally broadcast the notification update event
            broadcast(new Notifications($user->name, $notification->id));
    
            // Return a success response
            return response()->json(['message' => 'Notification marked as read.'], 200);
        }
    
        // Return an error if the notification is not found
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
        $unreadCount = $user->unreadNotifications->count();

        broadcast(new Notifications($user,$unreadNotifications));
        return response()->json(['notifications' => $unreadNotifications , 'count'=>$unreadCount], 200);
    }

    public function notificationCount(Request $request)
    {
        $user = Auth::user();

        $unreadCount = $user->unreadNotifications->count();

        // broadcast(new Notifications($user,$notification));


        return response()->json(['unreadCount' => $unreadCount], 200);
    }
}
