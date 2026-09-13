<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable
{
    use LogsActivity;
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
    'username',
    'full_name',
    'employee_id',
    'email',
    'password',
    'contact_number',
    'address',
    'is_active',
    'last_login_at',
    'profile_photo',
    'resume',
    'notes',
    'is_verified',
    'otp_expires_at',
    'otp_attempts',
    'otp_last_attempt_at',
    'otp_locked_until',
    'login_attempts',
    'locked_until',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'deleted_at' => 'datetime',
        'otp_last_attempt_at' => 'datetime',
        'otp_locked_until' => 'datetime',
        'locked_until' => 'datetime',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Relationship with OTP
     */
    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    /**
     * Get user's trusted devices
     */
    public function trustedDevices()
    {
        return $this->hasMany(UserTrustedDevice::class);
    }

    /**
     * Get user's active trusted devices
     */
    public function activeTrustedDevices()
    {
        return $this->trustedDevices()->active();
    }

    /**
     * Relationship with Activity Logs
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // ==================== OTP METHODS ====================

    /**
     * Generate OTP
     */
    public function generateOtp($type = 'login', $expiryMinutes = 10)
    {
        $this->otps()->where('is_used', false)->delete();
        
        // Reset attempts when generating new OTP
        $this->update([
            'otp_attempts' => 0,
            'otp_last_attempt_at' => null,
            'otp_locked_until' => null
        ]);
        
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        return $this->otps()->create([
            'code' => $code,
            'type' => $type,
            'expires_at' => now()->addMinutes($expiryMinutes),
            'is_used' => false,
        ]);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp($code, $type = 'login')
    {
        // Check if locked
        if ($this->otp_locked_until && now()->lt($this->otp_locked_until)) {
            return false;
        }
        
        $otp = $this->otps()
            ->where('code', $code)
            ->where('type', $type)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if ($otp) {
            $otp->update(['is_used' => true]);
            $this->update([
                'otp_attempts' => 0,
                'otp_last_attempt_at' => null,
                'otp_locked_until' => null
            ]);
            return true;
        }
        
        // Increment failed attempts
        $attempts = ($this->otp_attempts ?? 0) + 1;
        $this->update([
            'otp_attempts' => $attempts,
            'otp_last_attempt_at' => now()
        ]);
        
        // Lock after 3 attempts
        if ($attempts >= 3) {
            $this->update(['otp_locked_until' => now()->addMinutes(1)]);
        }
        
        return false;
    }

    /**
     * Send OTP via Email
     */
    public function sendOtpEmail($code)
    {
        \Mail::to($this->email)->send(new \App\Mail\OtpMail($code, $this->username));
    }

    // ==================== TRUSTED DEVICES METHODS ====================

    /**
     * Check if a device is trusted
     */
    public function isDeviceTrusted($deviceId)
    {
        return $this->activeTrustedDevices()
            ->where('device_id', $deviceId)
            ->exists();
    }

    /**
     * Get trusted devices count
     */
    public function getTrustedDevicesCountAttribute()
    {
        return $this->activeTrustedDevices()->count();
    }

    /**
     * Clear all trusted devices
     */
    public function clearTrustedDevices()
    {
        return $this->trustedDevices()->delete();
    }

    /**
     * Check if user requires OTP
     */
    public function requiresOtp($deviceId = null)
    {
        // Check if OTP is locked
        if ($this->otp_locked_until && now()->lt($this->otp_locked_until)) {
            return true;
        }

        // If device is trusted, no OTP needed
        if ($deviceId && $this->isDeviceTrusted($deviceId)) {
            return false;
        }

        return true;
    }

    // ==================== HELPER METHODS ====================

    /**
     * Get user initial for avatar
     */
    public function getInitialAttribute()
    {
        return strtoupper(substr($this->full_name ?? $this->username, 0, 1));
    }

    /**
     * Get user's role names as string
     */
    public function getRoleNamesAttribute()
    {
        return $this->roles->pluck('name')->implode(', ');
    }

    /**
     * Check if user is locked
     */
    public function isLocked()
    {
        return $this->locked_until && now()->lt($this->locked_until);
    }

    /**
     * Get lock time remaining in seconds
     */
    public function getLockTimeRemainingAttribute()
    {
        if (!$this->locked_until || now()->gt($this->locked_until)) {
            return 0;
        }
        return now()->diffInSeconds($this->locked_until);
    }

    /**
     * Send password reset notification
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    // ==================== SCOPES ====================

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for users with OTP enabled
     */
    public function scopeOtpEnabled($query)
    {
        return $query->where('otp_enabled', true);
    }
}