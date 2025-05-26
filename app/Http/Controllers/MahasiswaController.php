<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MahasiswaController extends Controller
{
    /**
     * Display mahasiswa dashboard.
     */
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    public function profile()
    {
        $mahasiswa = Auth::user()->mahasiswa->load(['keahlianUtama', 'keahlianTambahan']);
        return view('mahasiswa.profile.index', compact('mahasiswa'));
    }

    public function editProfile()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        // Ambil data prodi dan keahlian untuk dropdown
        $prodis = \App\Models\Prodi::all();
        $keahlians = \App\Models\Keahlian::all();
        return view('mahasiswa.profile.edit', compact('mahasiswa', 'prodis', 'keahlians'));
    }

    public function updateProfile(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $validated = $request->validate([
            'mahasiswa_nomor_telepon' => 'nullable|string|max:20',
            'keahlian_id' => 'required|exists:m_keahlians,id',
            'keahlian_tambahan' => 'array',
            'keahlian_tambahan.*' => 'exists:m_keahlians,id',
            'mahasiswa_provinsi' => 'nullable|string|max:100',
            'mahasiswa_kota' => 'nullable|string|max:100',
            'mahasiswa_kecamatan' => 'nullable|string|max:100',
            'mahasiswa_desa' => 'nullable|string|max:100',
            'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'keahlian_sertifikat' => 'nullable|url',
            'keahlian_sertifikat_tambahan' => 'array',
            'keahlian_sertifikat_tambahan.*' => 'nullable|url',
        ]);

        try {
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $path = $file->store('mahasiswa_photos', 'public');
                $validated['mahasiswa_photo'] = $path;
            }

            // Update keahlian utama, sertifikat utama, dan field lain
            $mahasiswa->update([
                'mahasiswa_nomor_telepon' => $validated['mahasiswa_nomor_telepon'] ?? null,
                'keahlian_id' => $validated['keahlian_id'],
                'keahlian_sertifikat' => $validated['keahlian_sertifikat'] ?? null,
                'mahasiswa_provinsi' => $validated['mahasiswa_provinsi'] ?? null,
                'mahasiswa_kota' => $validated['mahasiswa_kota'] ?? null,
                'mahasiswa_kecamatan' => $validated['mahasiswa_kecamatan'] ?? null,
                'mahasiswa_desa' => $validated['mahasiswa_desa'] ?? null,
                'mahasiswa_photo' => $validated['mahasiswa_photo'] ?? $mahasiswa->mahasiswa_photo,
            ]);

            // Update keahlian tambahan (many-to-many) beserta sertifikatnya
            $keahlianTambahan = $validated['keahlian_tambahan'] ?? [];
            $sertifikatTambahan = $validated['keahlian_sertifikat_tambahan'] ?? [];
            $pivotData = [];
            foreach ($keahlianTambahan as $kid) {
                $pivotData[$kid] = [
                    'keahlian_sertifikat' => $sertifikatTambahan[$kid] ?? null
                ];
            }
            $mahasiswa->keahlianTambahan()->sync($pivotData);

            if ($request->ajax()) {
                return response()->json(['message' => 'Profil berhasil diperbarui.']);
            }
            return redirect()->route('mahasiswa.profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Profil gagal diperbarui.'], 500);
            }
            return redirect()->back()->withErrors(['error' => 'Profil gagal diperbarui.']);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->user_password = bcrypt($request->password);
        $user->save();

        if ($request->ajax()) {
            return response()->json(['message' => 'Password berhasil diubah.']);
        }

        return redirect()->route('mahasiswa.profile')->with('success', 'Password berhasil diubah.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $mahasiswa = Auth::user()->mahasiswa;

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('mahasiswa_photos', 'public');
            // Simpan path file ke database
            $mahasiswa->mahasiswa_photo = $path;
            // Jika ingin tetap menggunakan getClientOriginalExtension(), bisa untuk logging atau keperluan lain
            $ext = $file->getClientOriginalExtension();
            // Contoh: log ekstensi (tidak mempengaruhi penyimpanan path)
            // \Log::info('Ekstensi file upload: ' . $ext);
            $mahasiswa->save();
        }

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Foto profil berhasil diubah.',
                'photo_url' => asset('storage/' . $mahasiswa->mahasiswa_photo)
            ]);
        }

        return redirect()->back()->with('success', 'Foto profil berhasil diubah.');
    }
}