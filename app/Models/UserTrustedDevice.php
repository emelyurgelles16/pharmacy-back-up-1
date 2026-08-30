<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTrustedDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_id',
        'device_name',
        'ip_address',
        'user_agent',
        'last_used_at',
        'expires_at',
        'is_active'
    ];

    protected $casts = [
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    /**
     * Get the user that owns the device
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if device is expired
     */
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at <= now();
    }

    /**
     * Check if device is trusted (active and not expired)
     */
    public function isTrusted()
    {
        return $this->is_active && (!$this->expires_at || $this->expires_at > now());
    }

    /**
     * Scope for active devices
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Scope for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get device type from user agent
     */
    public function getDeviceTypeAttribute()
    {
        $ua = $this->user_agent ?? '';
        
        if (str_contains($ua, 'Mobile')) {
            return '📱 Mobile';
        } elseif (str_contains($ua, 'Windows')) {
            return '💻 Windows';
        } elseif (str_contains($ua, 'Macintosh')) {
            return '🍎 Mac';
        } elseif (str_contains($ua, 'Linux')) {
            return '🐧 Linux';
        } elseif (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) {
            return '📱 iOS';
        } elseif (str_contains($ua, 'Android')) {
            return '📱 Android';
        }
        
        return '🖥️ Unknown';
    }

    /**
     * Get time remaining
     */
    public function getTimeRemainingAttribute()
    {
        if (!$this->expires_at) {
            return 'Never expires';
        }
        
        $diff = now()->diff($this->expires_at);
        if ($diff->invert) {
            return 'Expired';
        }
        
        if ($diff->days > 0) {
            return $diff->days . ' day' . ($diff->days > 1 ? 's' : '');
        }
        
        if ($diff->h > 0) {
            return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '');
        }
        
        return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '');
    }
}