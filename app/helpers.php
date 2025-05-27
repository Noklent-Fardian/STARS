<?php

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