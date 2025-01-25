<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
  public function index()
  {
    $notifications = Auth::user()
      ->notifications()
      ->latest()
      ->paginate(10);

    return view('notifications.index', compact('notifications'));
  }

  public function markAsRead(DatabaseNotification $notification)
  {
    if ($notification->notifiable_id !== Auth::id()) {
      abort(403);
    }

    $notification->markAsRead();

    return back()->with('success', 'Notification marked as read.');
  }

  public function markAllAsRead()
  {
    Auth::user()->unreadNotifications->markAsRead();

    return back()->with('success', 'All notifications marked as read.');
  }
}
