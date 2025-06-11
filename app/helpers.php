<?php


use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

/**
 * Get authenticated user's profile photo URL
 * 
 * @return string
 */
function getUserProfilePhoto(): string
{
    $user = Auth::user();

    if ($user->admin && $user->admin->admin_photo) {
        return asset('storage/admin_photos/' . $user->admin->admin_photo);
    }

    if ($user->dosen && $user->dosen->dosen_photo) {
        return asset('storage/' . $user->dosen->dosen_photo);
    }

    if ($user->mahasiswa && $user->mahasiswa->mahasiswa_photo) {
        return asset('storage/' . $user->mahasiswa->mahasiswa_photo);
    }

    return asset('RuangAdmin/img/boy.png');
}

/**
 * Get authenticated user's display name
 * 
 * @return string
 */
function getUserDisplayName(): string
{
    $user = Auth::user();

    return $user->admin->admin_name ??
        $user->dosen->dosen_nama ??
        $user->mahasiswa->mahasiswa_nama ??
        $user->username;
}
function getUserProfileRoute(): string
{
    $user = Auth::user();

    if ($user->admin) {
        return route('admin.profile');
    }

    if ($user->dosen) {
        return route('dosen.profile');
    }

    if ($user->mahasiswa) {
        return route('mahasiswa.profile');
    }

    return route('admin.profile');
}
if (!function_exists('getUnreadNotifications')) {
    function getUnreadNotifications()
    {
        if (!Auth::check()) {
            return [];
        }

        $notifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'message' => $notification->message,
                    'url' => $notification->url,
                    'icon' => $notification->icon,
                    'icon_bg' => $notification->icon_bg,
                    'is_read' => $notification->is_read,
                    'created_at' => $notification->formatted_created_at,
                ];
            })
            ->toArray();

        return $notifications;
    }
}


if (!function_exists('createNotification')) {
    function createNotification($userId, $type, $message, $url, $icon = 'fas fa-bell', $iconBg = 'bg-primary', $relatedId = null, $relatedType = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $type,
            'message' => $message,
            'url' => $url,
            'icon' => $icon,
            'icon_bg' => $iconBg,
            'is_read' => false,
            'related_id' => $relatedId,
            'related_type' => $relatedType,
        ]);
    }
}
