<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\OtpController;

class TrustDeviceMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user) {
            $deviceId = hash('sha256', $request->userAgent() . $request->header('sec-ch-ua-platform', 'unknown'));
            
            // Check if device is trusted
            if (OtpController::isDeviceTrustedStatic($user, $request)) {
                return $next($request);
            }
            
            // If not trusted, redirect to OTP verification
            return redirect()->route('otp.verify')->with('error', 'Please verify your device.');
        }

        return $next($request);
    }
}