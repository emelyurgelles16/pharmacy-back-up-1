<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        $key = $request->input('key');
        
        if (!$key) {
            return response()->json(['success' => false], 400);
        }

        $readNotifications = session('read_notifications', []);
        
        if (!in_array($key, $readNotifications)) {
            $readNotifications[] = $key;
            session(['read_notifications' => $readNotifications]);
        }

        return response()->json(['success' => true]);
    }

    public function markAllAsRead(Request $request)
    {
        session(['read_notifications' => ['expired', 'near_expiry', 'low_stock', 'out_of_stock']]);
        return response()->json(['success' => true]);
    }
}