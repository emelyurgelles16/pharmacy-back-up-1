<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserTrustedDevice;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class OtpController extends Controller
{
    public function showVerificationForm()
    {
        // ✅ If already logged in, redirect to dashboard
        if (auth()->check()) {
            \Log::info('⚠️ User already logged in, redirecting to dashboard');
            return redirect()->route('dashboard');
        }

        $user = null;

        if (session('temp_user')) {
            $user = (object) session('temp_user');
        } elseif (session('otp_user_id')) {
            $user = User::find(session('otp_user_id'));
        } elseif (session('user_id')) {
            $user = User::find(session('user_id'));
        }

        \Log::info('OTP Page Load - Session Data:', [
            'otp_user_id' => session('otp_user_id'),
            'user_id' => session('user_id'),
            'temp_user' => session('temp_user'),
            'auth_check' => auth()->check(),
            'user_found' => $user ? $user->username : 'none'
        ]);

        if (!$user) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        // Check if device is already trusted
        $deviceId = $this->generateDeviceId(request());
        if ($this->isDeviceTrusted($user, $deviceId)) {
            Auth::login($user);
            session()->forget(['otp_user_id', 'selected_role', 'temp_user', 'user_id']);
            return redirect()->route('dashboard')->with('success', 'Welcome back!');
        }

        return view('auth.verify-otp', compact('user'));
    }

    public function verify(Request $request)
    {
        \Log::info('🚀 STEP 1: Verify method started');

        try {
            \Log::info('🚀 STEP 1.1: Validating request...');
            $request->validate([
                'otp' => 'required|string|size:6',
                'remember' => 'nullable|boolean'
            ]);
            \Log::info('✅ STEP 1.2: Validation passed');

            \Log::info('🔍 STEP 2: OTP entered: ' . $request->otp);
            \Log::info('🔍 STEP 3: Session OTP User ID: ' . session('otp_user_id'));

            $userId = session('otp_user_id') ?? session('user_id');
            $selectedRole = session('selected_role');

            \Log::info('🔍 STEP 3.1: User ID from session: ' . ($userId ?? 'null'));

            if (!$userId) {
                \Log::error('❌ STEP 4: No user ID in session');
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            }

            \Log::info('✅ STEP 5: User ID found: ' . $userId);

            $user = User::find($userId);

            if (!$user) {
                \Log::error('❌ STEP 6: User not found with ID: ' . $userId);
                return redirect()->route('login')->with('error', 'User not found.');
            }

            \Log::info('✅ STEP 7: User found: ' . $user->username . ' (ID: ' . $user->id . ')');

            // ✅ MANUAL OTP CHECK
            \Log::info('🔍 STEP 7.1: Checking OTP in database...');
            \Log::info('   - user_id: ' . $user->id);
            \Log::info('   - code: ' . $request->otp);

            $otpRecord = DB::table('otps')
                ->where('user_id', $user->id)
                ->where('code', $request->otp)
                ->where('type', 'login')
                ->where('is_used', 0)
                ->where('expires_at', '>', now())
                ->first();

            \Log::info('🔍 STEP 8: OTP Record found: ' . ($otpRecord ? 'YES' : 'NO'));

            if (!$otpRecord) {
                \Log::error('❌ STEP 9: OTP NOT FOUND or expired');
                
                $attempts = session('otp_attempts', 0) + 1;
                session(['otp_attempts' => $attempts]);

                $remaining = 3 - $attempts;

                if ($attempts >= 3) {
                    session(['otp_locked_until' => now()->addMinutes(1)]);
                    session(['otp_attempts' => 0]);
                    return back()->with('error', 'Too many failed attempts. Your account is locked for 1 minute.');
                }

                return back()->with('error', "Invalid OTP. You have {$remaining} attempt(s) remaining.");
            }

            \Log::info('✅ STEP 10: OTP found! ID: ' . $otpRecord->id);
            \Log::info('   - Code: ' . $otpRecord->code);
            \Log::info('   - is_used: ' . $otpRecord->is_used);
            \Log::info('   - expires_at: ' . $otpRecord->expires_at);

            // ✅ MARK OTP AS USED
            \Log::info('🔍 STEP 10.1: Marking OTP as used...');
            DB::table('otps')
                ->where('id', $otpRecord->id)
                ->update(['is_used' => 1]);
            \Log::info('✅ STEP 11: OTP marked as used');

            // ✅ CLEAR SESSION
            \Log::info('🔍 STEP 11.1: Clearing session...');
            session()->forget([
                'otp_attempts',
                'otp_locked_until',
                'otp_user_id',
                'user_id',
                'selected_role',
                'temp_user'
            ]);
            \Log::info('✅ STEP 12: Session cleared');

            // ✅ LOGIN
            \Log::info('🔍 STEP 12.1: Logging in user...');
            Auth::login($user);
            session()->save();
            \Log::info('✅ STEP 13: User logged in');
            \Log::info('   - auth()->check(): ' . (auth()->check() ? 'TRUE' : 'FALSE'));
            \Log::info('   - auth()->id(): ' . auth()->id());

            if ($selectedRole) {
                \Log::info('🔍 STEP 13.1: Syncing role: ' . $selectedRole);
                $user->syncRoles([$selectedRole]);
            }

            ActivityLog::log(
                $user->id,
                $user->username,
                'otp_verified',
                'Auth',
                'OTP verified successfully for user: ' . $user->username,
                'Success'
            );

            // Store trusted device
            if ($request->remember) {
                \Log::info('🔍 STEP 13.2: Storing trusted device...');
                try {
                    $this->storeTrustedDevice($user, $request);
                } catch (\Exception $e) {
                    \Log::error('Failed to store trusted device: ' . $e->getMessage());
                }
            }

            \Log::info('✅ STEP 14: Redirecting to dashboard...');

            return redirect('/dashboard')->with('success', 'Login successful!');

        } catch (\Exception $e) {
            \Log::error('❌ CRITICAL ERROR in verify(): ' . $e->getMessage());
            \Log::error('   - File: ' . $e->getFile());
            \Log::error('   - Line: ' . $e->getLine());
            \Log::error('   - Trace: ' . $e->getTraceAsString());
            return back()->with('error', 'System error: ' . $e->getMessage());
        }
    }

    public function resend(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        $userId = session('otp_user_id') ?? session('user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found.');
        }

        session()->forget(['otp_attempts', 'otp_locked_until']);

        $otp = $user->generateOtp('login', 10);
        $user->sendOtpEmail($otp->code);

        ActivityLog::log(
            $user->id,
            $user->username,
            'otp_resent',
            'Auth',
            'OTP resent for user: ' . $user->username,
            'Success'
        );

        return back()->with('info', 'A new OTP has been sent to your email.');
    }

    private function storeTrustedDevice($user, $request)
    {
        $deviceId = $this->generateDeviceId($request);
        $deviceName = $this->getDeviceName($request);

        if (!Schema::hasTable('user_trusted_devices')) {
            session(['trusted_device_' . $user->id => $deviceId]);
            session(['trusted_device_expiry_' . $user->id => now()->addDays(30)->timestamp]);
            return;
        }

        $existing = UserTrustedDevice::where('user_id', $user->id)
            ->where('device_id', $deviceId)
            ->first();

        if ($existing) {
            $existing->update([
                'last_used_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'expires_at' => now()->addDays(30),
                'is_active' => true,
            ]);
        } else {
            $deviceCount = UserTrustedDevice::where('user_id', $user->id)
                ->where('is_active', true)
                ->count();

            if ($deviceCount >= 5) {
                $oldest = UserTrustedDevice::where('user_id', $user->id)
                    ->where('is_active', true)
                    ->orderBy('last_used_at')
                    ->first();
                if ($oldest) {
                    $oldest->update(['is_active' => false]);
                }
            }

            UserTrustedDevice::create([
                'user_id' => $user->id,
                'device_id' => $deviceId,
                'device_name' => $deviceName,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'last_used_at' => now(),
                'expires_at' => now()->addDays(30),
                'is_active' => true,
            ]);
        }

        session(['trusted_device_' . $user->id => $deviceId]);
    }

    private function isDeviceTrusted($user, $deviceId)
    {
        try {
            if (Schema::hasTable('user_trusted_devices')) {
                $trusted = UserTrustedDevice::where('user_id', $user->id)
                    ->where('device_id', $deviceId)
                    ->where('is_active', true)
                    ->where(function($query) {
                        $query->whereNull('expires_at')
                              ->orWhere('expires_at', '>', now());
                    })
                    ->exists();

                if ($trusted) {
                    UserTrustedDevice::where('user_id', $user->id)
                        ->where('device_id', $deviceId)
                        ->update(['last_used_at' => now()]);
                    return true;
                }
            }

            $storedDeviceId = session('trusted_device_' . $user->id);
            $expiry = session('trusted_device_expiry_' . $user->id);

            if ($storedDeviceId === $deviceId && $expiry && now()->timestamp < $expiry) {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            \Log::error('Error checking trusted device: ' . $e->getMessage());
            return false;
        }
    }

    public static function isDeviceTrustedStatic($user, $request)
    {
        $controller = new self();
        $deviceId = $controller->generateDeviceId($request);
        return $controller->isDeviceTrusted($user, $deviceId);
    }

    private function generateDeviceId($request)
    {
        $data = [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'platform' => $request->header('sec-ch-ua-platform'),
            'mobile' => $request->header('sec-ch-ua-mobile'),
        ];
        
        return hash('sha256', json_encode($data));
    }

    private function getDeviceName($request)
    {
        $platform = $request->header('sec-ch-ua-platform') ?? 'Unknown';
        $userAgent = $request->header('User-Agent') ?? '';
        
        if (str_contains($userAgent, 'Edg/')) {
            return 'Edge on ' . $platform;
        } elseif (str_contains($userAgent, 'Chrome/') && !str_contains($userAgent, 'Edg/')) {
            return 'Chrome on ' . $platform;
        } elseif (str_contains($userAgent, 'Firefox/')) {
            return 'Firefox on ' . $platform;
        } elseif (str_contains($userAgent, 'Safari/') && !str_contains($userAgent, 'Chrome/') && !str_contains($userAgent, 'Edg/')) {
            return 'Safari on ' . $platform;
        } elseif (str_contains($userAgent, 'Mobile')) {
            return 'Mobile Device';
        }
        
        return $platform . ' Browser';
    }

    public function verifyWithLink(Request $request)
    {
        $code = $request->query('code');

        if (!$code) {
            return redirect()->route('otp.verify')->with('error', 'Invalid verification link.');
        }

        $userId = session('otp_user_id') ?? session('user_id');
        $selectedRole = session('selected_role');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found.');
        }

        if ($user->verifyOtp($code, 'login')) {
            Auth::login($user);
            
            if ($selectedRole) {
                $user->syncRoles([$selectedRole]);
            }

            ActivityLog::log(
                $user->id,
                $user->username,
                'otp_verified_link',
                'Auth',
                'OTP verified via magic link for user: ' . $user->username,
                'Success'
            );

            session()->forget(['otp_user_id', 'selected_role', 'temp_user', 'user_id']);

            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        ActivityLog::log(
            $user->id,
            $user->username,
            'otp_link_failed',
            'Auth',
            'OTP magic link verification failed for user: ' . $user->username,
            'Failed'
        );

        return redirect()->route('otp.verify')->with('error', 'Invalid or expired OTP. Please try again.');
    }

    public function trustedDevices(Request $request)
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $devices = UserTrustedDevice::where('user_id', $user->id)
            ->where('is_active', true)
            ->orderBy('last_used_at', 'desc')
            ->get();

        return view('settings.trusted-devices', compact('devices'));
    }

    public function removeDevice(Request $request, $deviceId)
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $device = UserTrustedDevice::where('user_id', $user->id)
            ->where('device_id', $deviceId)
            ->first();

        if (!$device) {
            return response()->json(['success' => false, 'message' => 'Device not found'], 404);
        }

        $device->delete();

        ActivityLog::log(
            $user->id,
            $user->username,
            'remove_trusted_device',
            'Security',
            'Removed trusted device: ' . ($device->device_name ?? 'Unknown'),
            'Success'
        );

        return response()->json([
            'success' => true,
            'message' => 'Device removed successfully!'
        ]);
    }

    public function clearAllDevices(Request $request)
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        UserTrustedDevice::where('user_id', $user->id)->delete();

        ActivityLog::log(
            $user->id,
            $user->username,
            'clear_trusted_devices',
            'Security',
            'Cleared all trusted devices',
            'Success'
        );

        return response()->json([
            'success' => true,
            'message' => 'All trusted devices cleared!'
        ]);
    }
}