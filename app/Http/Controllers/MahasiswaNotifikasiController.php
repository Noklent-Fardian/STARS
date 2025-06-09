<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaNotifikasiController extends Controller
{
    // filepath: [MahasiswaNotifikasiController.php](http://_vscodecontentref_/1)
    public function index()
    {
        $notifikasi = session('notifikasi_mahasiswa', []);
        return view('mahasiswa.notifikasi.index', compact('notifikasi'));
    }

    public function show($index)
    {
        try {
            $notifikasi = session()->get('notifikasi_mahasiswa', []);

            if (!isset($notifikasi[$index])) {
                return redirect()->route('mahasiswa.notifikasi.index')->with('error', 'Notifikasi tidak ditemukan');
            }

            // Tandai sebagai dibaca
            $notifikasi[$index]['is_read'] = true;
            session()->put('notifikasi_mahasiswa', $notifikasi);

            return view('mahasiswa.notifikasi.show', [
                'notifikasi' => (object) $notifikasi[$index]
            ]);

        } catch (\Exception $e) {
            return redirect()->route('mahasiswa.notifikasi.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function markAsRead($index)
    {
        try {
            $notifikasi = session()->get('notifikasi_mahasiswa', []);

            if (isset($notifikasi[$index])) {
                $notifikasi[$index]['is_read'] = true;
                session()->put('notifikasi_mahasiswa', $notifikasi);

                return response()->json(['success' => true, 'message' => 'Notifikasi ditandai sebagai dibaca.']);
            }

            return response()->json(['success' => false, 'message' => 'Notifikasi tidak ditemukan.'], 404);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memproses permintaan.'], 500);
        }
    }

    public function markAllAsRead()
    {
        try {
            $notifikasi = session()->get('notifikasi_mahasiswa', []);
            foreach ($notifikasi as &$n) {
                $n['is_read'] = true;
            }

            session()->put('notifikasi_mahasiswa', $notifikasi);

            return response()->json(['success' => true, 'message' => 'Semua notifikasi ditandai sebagai dibaca.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memproses.'], 500);
        }
    }

    public function getUnreadCount()
    {
        try {
            $notifikasi = session()->get('notifikasi_mahasiswa', []);
            $count = collect($notifikasi)->where('is_read', false)->count();

            return response()->json(['success' => true, 'count' => $count]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'count' => 0]);
        }
    }

    // Tambahkan untuk testing/manual entry notifikasi
    public function simulateNotifikasi()
    {
        $notifikasi = [
            [
                'judul' => 'Selamat Datang!',
                'pesan' => 'Cek rekomendasi lomba yang cocok untukmu.',
                'tanggal' => now()->format('Y-m-d'),
                'is_read' => false
            ],
            [
                'judul' => 'Update Profil',
                'pesan' => 'Perbarui bidang keahlianmu agar hasil rekomendasi lebih akurat.',
                'tanggal' => now()->subDay()->format('Y-m-d'),
                'is_read' => false
            ]
        ];

        session()->put('notifikasi_mahasiswa', $notifikasi);

        return redirect()->route('mahasiswa.notifikasi.index')->with('success', 'Simulasi notifikasi berhasil.');
    }
}
