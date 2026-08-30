<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'pharmacy_name' => Setting::get('pharmacy_name', 'AER Pharmacy'),
            'pharmacy_address' => Setting::get('pharmacy_address', ''),
            'pharmacy_contact' => Setting::get('pharmacy_contact', ''),
            'pharmacy_email' => Setting::get('pharmacy_email', ''),
            'pharmacy_tin' => Setting::get('pharmacy_tin', ''),
            'pharmacy_logo' => Setting::get('pharmacy_logo', ''),
            'backup_schedule' => Setting::get('backup_schedule', 'weekly'),
            'backup_retention' => Setting::get('backup_retention', '30'),
        ];
        
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'pharmacy_name' => 'required|string|max:255',
            'pharmacy_address' => 'nullable|string',
            'pharmacy_contact' => 'nullable|string|max:20',
            'pharmacy_email' => 'nullable|email|max:255',
            'pharmacy_tin' => 'nullable|string|max:50',
            'pharmacy_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('pharmacy_logo')) {
            $oldLogo = Setting::get('pharmacy_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            
            $logo = $request->file('pharmacy_logo');
            $logoPath = $logo->store('pharmacy', 'public');
            $validated['pharmacy_logo'] = $logoPath;
        }

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'pharmacy');
        }

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'update_pharmacy_info',
            'Settings',
            'Updated pharmacy information: ' . $validated['pharmacy_name'],
            'Success'
        );

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully!'
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('settings.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'resume' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $oldName = $user->full_name;
        $oldEmail = $user->email;
        $oldContact = $user->contact_number;
        $oldAddress = $user->address;

        $user->full_name = $validated['full_name'];
        $user->email = $validated['email'];
        $user->contact_number = $validated['contact_number'] ?? $user->contact_number;
        $user->address = $validated['address'] ?? $user->address;

        $changes = [];
        if ($oldName != $user->full_name) $changes[] = "name: {$oldName} → {$user->full_name}";
        if ($oldEmail != $user->email) $changes[] = "email: {$oldEmail} → {$user->email}";
        if ($oldContact != $user->contact_number) $changes[] = "contact: {$oldContact} → {$user->contact_number}";
        if ($oldAddress != $user->address) $changes[] = "address: {$oldAddress} → {$user->address}";

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
            $changes[] = "password: changed";
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $user->profile_photo = $path;
            $changes[] = "profile photo: updated";
        }

        if ($request->hasFile('resume')) {
            if ($user->resume) {
                Storage::disk('public')->delete($user->resume);
            }
            $path = $request->file('resume')->store('resumes', 'public');
            $user->resume = $path;
            $changes[] = "resume: updated";
        }

        $user->save();

        $changeList = !empty($changes) ? ' - Changes: ' . implode(', ', $changes) : '';

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'update_profile',
            'Settings',
            'Updated profile for: ' . $user->username . $changeList,
            'Success'
        );

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!'
        ]);
    }

    public function activityLogs()
    {
        $logs = ActivityLog::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('settings.activity-logs', compact('logs'));
    }

    public function filterActivityLogs(Request $request)
    {
        $query = ActivityLog::where('user_id', Auth::id());
        
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        if ($request->action) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }
        
        $logs = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('settings.activity-logs', compact('logs'));
    }
}