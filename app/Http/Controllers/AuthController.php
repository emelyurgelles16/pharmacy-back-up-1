<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    // === SHOW LOGIN FORM ===
    public function showLoginForm()
    {
        return view('auth.login');
    }

public function login(Request $request)
{
    // ✅ Validate email and password
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // ✅ Find user by email
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->with('error', 'Invalid credentials.');
    }

    if ($user->locked_until && now()->lt($user->locked_until)) {
        $secondsLeft = now()->diffInSeconds($user->locked_until);
        $minutesLeft = ceil($secondsLeft / 60);
        return back()->with('error', 'Account is temporarily locked. Please try again in ' . $minutesLeft . ' minute(s).');
    }

    // ✅ Check credentials WITHOUT logging in yet
    if (Hash::check($request->password, $user->password)) {
        DB::table('users')->where('id', $user->id)->update([
            'login_attempts' => 0,
            'locked_until' => null
        ]);

        ActivityLog::log(
            $user->id,
            $user->username,
            'login_attempt',
            'Auth',
            'User login attempt for: ' . $user->username,
            'Success'
        );

        // ✅ Get user's role
        $roles = $user->roles->pluck('name')->toArray();
        if (empty($roles)) {
            return back()->with('error', 'No role assigned to this user.');
        }
        $selectedRole = $roles[0];

        // ✅ CHECK IF DEVICE IS TRUSTED (Using improved method)
        $deviceId = hash('sha256', $request->userAgent() . $request->header('sec-ch-ua-platform', 'unknown'));
        
        // ✅ LOG FOR DEBUGGING
        \Log::info('🔍 LOGIN DEVICE CHECK:', [
            'user' => $user->username,
            'device_id' => $deviceId,
            'is_trusted' => $user->isDeviceTrusted($deviceId),
            'user_agent' => substr($request->userAgent(), 0, 50) . '...'
        ]);

        // ✅ IF TRUSTED, SKIP OTP
        if ($user->isDeviceTrusted($deviceId)) {
            Auth::login($user);
            
            ActivityLog::log(
                $user->id,
                $user->username,
                'login_trusted_device',
                'Auth',
                'User logged in via trusted device: ' . $user->username,
                'Success'
            );
            
            return redirect()->route('dashboard')->with('success', 'Welcome back!');
        }

        // ✅ GENERATE OTP (DO NOT LOGIN YET)
        $otp = $user->generateOtp('login', 10);
        
        // ✅ SEND OTP EMAIL
        $user->sendOtpEmail($otp->code);

        // ✅ STORE SESSION (but DO NOT LOGIN)
        session(['otp_user_id' => $user->id]);
        session(['selected_role' => $selectedRole]);
        session(['temp_user' => [
            'id' => $user->id,
            'email' => $user->email,
            'username' => $user->username,
            'role' => $selectedRole
        ]]);

        // ✅ DEBUG - Log that OTP was sent
        \Log::info('📧 OTP Sent to: ' . $user->email . ' | OTP: ' . $otp->code);

        // ✅ REDIRECT TO OTP PAGE (NOT LOGGED IN YET)
        return redirect()->route('otp.verify')
            ->with('info', 'Please enter the OTP sent to ' . $user->email);
    }

    // ✅ Failed login attempts
    $currentAttempts = DB::table('users')->where('email', $request->email)->value('login_attempts');
    $newAttempts = ($currentAttempts ?? 0) + 1;

    DB::table('users')->where('email', $request->email)->update([
        'login_attempts' => $newAttempts
    ]);

    ActivityLog::log(
        null,
        $request->email,
        'login_failed',
        'Auth',
        'Failed login attempt for user: ' . $request->email,
        'Failed'
    );

    if ($newAttempts >= 3) {
        DB::table('users')->where('email', $request->email)->update([
            'locked_until' => now()->addMinutes(1)
        ]);
        return back()->with('error', 'Too many failed attempts. Your account is locked for 1 minute.');
    } else {
        $remaining = 3 - $newAttempts;
        return back()->with('error', 'Invalid credentials. You have ' . $remaining . ' attempt(s) remaining.');
    }
}

    // === SHOW REGISTER FORM (ADMIN ONLY) ===
    public function showRegisterForm()
    {
        if (!auth()->check() || !auth()->user()->can('create users')) {
            return redirect()->route('login')->with('error', 'You do not have permission to access this page.');
        }
        return view('register');
    }

    // === HANDLE REGISTER (ADMIN ONLY) ===
    public function register(Request $request)
    {
        if (!auth()->check() || !auth()->user()->can('create users')) {
            return redirect()->route('login')->with('error', 'You do not have permission to create accounts.');
        }

        $request->validate([
            'username' => 'required|unique:users,username',
            'full_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::create([
            'username' => $request->username,
            'full_name' => $request->full_name ?? $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        $user->assignRole($request->role);

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'add_user',
            'User & Access',
            'Created new user: ' . $request->username . ' with role: ' . $request->role,
            'Success'
        );

        return redirect()->route('user-access.index')->with('success', 'Employee created successfully!');
    }

    // === DASHBOARD ===
    public function dashboard()
    {
        $user = Auth::user();
        return view('dashboard', [
            'username' => $user->username,
            'initial' => strtoupper($user->username[0]),
        ]);
    }

    // === LOGOUT ===
    public function logout(Request $request)
    {
        if (auth()->check()) {
            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'logout',
                'Auth',
                'User logged out successfully',
                'Success'
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully!');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('forgot_password');
    }

    /**
     * Send password reset link (with security)
     */
    public function submitForgotPassword(Request $request)
    {
        $request->validate([
            'username' => 'required|string|exists:users,username',
            'email' => 'required|email|exists:users,email'
        ]);

        $throttleKey = 'password_reset_' . $request->email;
        if (cache()->has($throttleKey)) {
            return back()->with('error', 'Please wait 1 minute before requesting again.');
        }

        $user = User::where('email', $request->email)
                    ->where('username', $request->username)
                    ->first();

        if (!$user) {
            return back()->with('error', 'Username and email do not match our records.');
        }

        ActivityLog::log(
            $user->id,
            $user->username,
            'forgot_password',
            'Auth',
            'Password reset requested for user: ' . $user->username,
            'Success'
        );

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($request->email) . '&username=' . urlencode($request->username));

        Mail::to($user->email)->send(new ResetPasswordMail($resetUrl, $user->username));

        cache()->put($throttleKey, true, 60);

        return back()->with('success', 'Password reset link sent to your email!');
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm(Request $request, $token = null)
    {
        if (!$token) {
            $token = $request->route('token');
        }

        if (!$token) {
            $token = $request->query('token');
        }

        $email = $request->query('email');
        $username = $request->query('username');

        if (!$token || !$email || !$username) {
            return redirect()->route('login')->with('error', 'Invalid reset link. Missing required information.');
        }

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$resetRecord) {
            return redirect()->route('login')->with('error', 'Invalid or expired reset link.');
        }

        if (Carbon::parse($resetRecord->created_at)->addMinutes(60)->isPast()) {
            return redirect()->route('login')->with('error', 'Reset link has expired. Please request a new one.');
        }

        return view('reset_password', [
            'token' => $token,
            'email' => $email,
            'username' => $username
        ]);
    }

    /**
     * Reset password (with security validation)
     */
    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'username' => 'required|string',
            'password' => 'required|min:8|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/'
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.'
        ]);

        $user = User::withTrashed()->where('email', $request->email)
                    ->where('username', $request->username)
                    ->first();

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRecord) {
            return back()->with('error', 'Invalid or expired reset token.');
        }

        if (Carbon::parse($resetRecord->created_at)->addMinutes(60)->isPast()) {
            return back()->with('error', 'Reset token has expired. Please request a new one.');
        }

        ActivityLog::log(
            $user->id,
            $user->username,
            'reset_password',
            'Auth',
            'Password reset successfully for user: ' . $user->username,
            'Success'
        );

        $user->password = Hash::make($request->password);

        if ($user->trashed()) {
            $user->restore();
        }

        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password reset successfully! Please login with your new password.');
    }
}