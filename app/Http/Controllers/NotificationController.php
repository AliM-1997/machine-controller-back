<?php
namespace App\Http\Controllers;

use App\Events\Notifications;
use App\Models\Task;
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
        $user = Auth::user();
        
        $notification = $user->notifications()->find($notificationId);
    
        if ($notification) {
            $notification->markAsRead();
            $taskId = $notification->data['task_id'];

            $task = Task::find($taskId);
            if ($task) {
                $task->status = 'in progress';  
                $task->save();
            }

            broadcast(new Notifications($user->name, $notification->id));
    
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
        $unreadCount = $user->unreadNotifications->count();

        // broadcast(new Notifications($user,$unreadNotifications));
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
