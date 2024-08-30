<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;


class NotficationController extends Controller
{
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
    public function getAllNotifications()
{
    $user = Auth::user();
    $notifications = $user->notifications; 

    return response()->json(['notifications' => $notifications], 200);
}

    public function getUnreadNotifications()
{
    $user = Auth::user();
    User::where('id', $user->id)->
    $unreadNotifications = $user->getUnreadNotifications()->find();

    return response()->json(['notifications' => $unreadNotifications], 200);
}

}
