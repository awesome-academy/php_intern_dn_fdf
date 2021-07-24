<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifyController extends Controller
{
    public function getNotifyOrder()
    {
        $notifications = Auth::guard('web')->user()->notifications;

        foreach ($notifications as $notify) {
            $notify->markAsRead();
        }

        return response()->json($notifications, 200);
    }
}
