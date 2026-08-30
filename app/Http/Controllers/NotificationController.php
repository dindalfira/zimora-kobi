<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notification = Notification::where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->paginate(15);

        return view('notification.index', compact('notification'));
    }

    public function read(Notification $notification)
    {
        abort_unless(
            $notification->user_id === Auth::id(),
            403
        );

        $notification->update([
            'dibaca' => true,
            'dibaca_at' => now(),
        ]);

        if ($notification->url) {
            return redirect($notification->url);
        }

        return back();
    }

    public function readAll()
    {
        Notification::where('user_id', Auth::id())
            ->where('dibaca', false)
            ->update([
                'dibaca' => true,
                'dibaca_at' => now(),
            ]);

        return back();
    }
}
