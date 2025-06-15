<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class MahasiswaNotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        try {
            $notifications = Notification::where('user_id', $user->id)
                ->whereIn('type', ['Rekomendasi Lomba', 'Rekomendasi Lomba (SAW)'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('mahasiswa.notifikasi.index', compact('notifications'));
        } catch (\Exception $e) {
            return view('mahasiswa.notifikasi.index', ['notifications' => collect(), 'error' => 'Terjadi kesalahan saat memuat notifikasi: ' . $e->getMessage()]);
        }
    }

    public function rekomendasiIndex()
    {
        $user = Auth::user();
        
        try {
            $notifications = Notification::where('user_id', $user->id)
                ->whereIn('type', ['Rekomendasi Lomba', 'Rekomendasi Lomba (SAW)'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('mahasiswa.rekomendasi.index', compact('notifications'));
        } catch (\Exception $e) {
            return view('mahasiswa.rekomendasi.index', ['notifications' => collect(), 'error' => 'Terjadi kesalahan saat memuat rekomendasi: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        
        $notification = Notification::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        // Mark as read
        if (!$notification->read_at) {
            $notification->update(['read_at' => now()]);
        }

        return view('mahasiswa.rekomendasi.show', compact('notification'));
    }
}
