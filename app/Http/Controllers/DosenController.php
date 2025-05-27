<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Keahlian;
use App\Models\KeahlianDosen;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = Auth::user()->dosen;
        return view('dosbim.index', compact('dosen'));
    }
    public function profile()
    {
        $dosen = Auth::user()->dosen->load(['keahlianUtama', 'keahlianTambahan']);
        return view('dosbim.profile.index', compact('dosen'));
    }

    public function editProfile()
    {
        $dosen = Auth::user()->dosen;
        $prodis = Prodi::all();
        $keahlians = Keahlian::all();
        return view('dosbim.profile.edit', compact('dosen', 'prodis', 'keahlians'));
    }
    public function updateProfile(Request $request)
    {
        $dosen = Auth::user()->dosen;

        $validated = $request->validate([
            'dosen_nomor_telepon' => 'nullable|string|max:20',
            'keahlian_id' => 'required|exists:m_keahlians,id',
            'keahlian_tambahan' => 'array',
            'keahlian_tambahan.*' => 'exists:m_keahlians,id',
            'dosen_provinsi' => 'nullable|string|max:100',
            'dosen_kota' => 'nullable|string|max:100',
            'dosen_kecamatan' => 'nullable|string|max:100',
            'dosen_desa' => 'nullable|string|max:100',
            'dosen_photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'keahlian_sertifikat' => 'nullable|url',
            'keahlian_sertifikat_tambahan' => 'array',
            'keahlian_sertifikat_tambahan.*' => 'nullable|url',
        ]);

        try {
            if ($request->hasFile('dosen_photo')) {
                $file = $request->file('dosen_photo');
                $path = $file->store('dosen_photo', 'public');
                $validated['dosen_photo'] = $path;
            }

            $dosen->update([
                'dosen_nomor_telepon' => $validated['dosen_nomor_telepon'] ?? null,
                'keahlian_id' => $validated['keahlian_id'],
                'keahlian_sertifikat' => $validated['keahlian_sertifikat'] ?? null,
                'dosen_provinsi' => $validated['dosen_provinsi'] ?? null,
                'dosen_kota' => $validated['dosen_kota'] ?? null,
                'dosen_kecamatan' => $validated['dosen_kecamatan'] ?? null,
                'dosen_desa' => $validated['dosen_desa'] ?? null,
                'dosen_photo' => $validated['dosen_photo'] ?? $dosen->dosen_photo,
            ]);

            $keahlianTambahan = $validated['keahlian_tambahan'] ?? [];
            $sertifikatTambahan = $validated['keahlian_sertifikat_tambahan'] ?? [];
            $pivotData = [];
            foreach ($keahlianTambahan as $kid) {
                $pivotData[$kid] = [
                    'keahlian_sertifikat' => $sertifikatTambahan[$kid] ?? null
                ];
            }
            $dosen->keahlianTambahan()->sync($pivotData);

            if ($request->ajax()) {
                return response()->json(['message' => 'Profil berhasil diperbarui.']);
            }
            return redirect()->route('dosen.profile')->with('success', 'Profil berhasil diperbarui.');
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

        return redirect()->route('dosen.profile')->with('success', 'Password berhasil diubah.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'dosen_photo' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $dosen = Auth::user()->dosen;

        if ($request->hasFile('dosen_photo')) {
            $file = $request->file('dosen_photo');
            $path = $file->store('dosen_photos', 'public');
            $dosen->dosen_photo = $path;
            $dosen->save();
        }

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Foto profil berhasil diubah.',
                'photo_url' => asset('storage/' . $dosen->dosen_photo)
            ]);
        }

        return redirect()->back()->with('success', 'Foto profil berhasil diubah.');
    }
}