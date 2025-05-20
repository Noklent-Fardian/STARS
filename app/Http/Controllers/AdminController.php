<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function index()
    {
        $admin = Auth::user()->admin;
        return view('admin.index', compact('admin'));
    }


    public function mahasiswaIndex()
    {
        return view('admin.mahasiswa.index');
    }


    public function dosenIndex()
    {
        return view('admin.dosen.index');
    }


    public function adminIndex()
    {
        return redirect()->route('admin.adminManagement.index');
    }


    public function prestasiVerification()
    {
        return view('admin.prestasi.verification');
    }

    public function prestasiAkademik()
    {
        return view('admin.prestasi.akademik');
    }

    public function prestasiNonAkademik()
    {
        return view('admin.prestasi.non-akademik');
    }

    public function prestasiIndex()
    {
        return view('admin.prestasi.index');
    }

    public function prestasiReport()
    {
        return view('admin.prestasi.report');
    }

    public function lombaVerification()
    {
        return view('admin.lomba.verification');
    }

    public function lombaIndex()
    {
        return view('admin.adminKelolaLomba.index');
    }


    public function masterPeriode()
    {
        return view('admin.semester.index');
    }

    public function masterProdi()
    {
        return view('admin.master.prodi');
    }
    public function masterKeahlian()
    {
        //return view('admin.master.bidangKeahlian');
        return view('admin.bidangKeahlian.index');
    }
    // tingkatanLomba
    public function masterTingkatanLomba()
    {
        return view('admin.master.tingkatanLomba');
    }
    public function masterPeringkatLomba()
    {
        return view('admin.master.peringkatLomba');
    }

    public function profile()
    {
        $admin = Auth::user()->admin;
        return view('admin.profile.profile', compact('admin'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        $admin = Admin::where('user_id', $user->id)->first();
        return view('admin.profile.edit_profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $admin = Admin::where('user_id', $user->id)->first();

        $data = [
            'admin_name' => $request->admin_name,
            'admin_nomor_telepon' => $request->admin_nomor_telepon,
            'admin_gender' => $request->admin_gender,
        ];

        $admin->update($data);

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }

    public function updatePhoto(Request $request)
    {
        $messages = [
            'admin_photo.required' => 'Silakan pilih foto terlebih dahulu.',
            'admin_photo.image' => 'File harus berupa gambar.',
            'admin_photo.mimes' => 'Format foto harus jpeg, png, atau jpg.',
            'admin_photo.max' => 'Ukuran foto tidak boleh lebih dari 2MB.',
        ];

        $validator = \Validator::make($request->all(), [
            'admin_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('admin.profile')
                ->with('error', $validator->errors()->first())
                ->withErrors($validator);
        }

        $user = Auth::user();
        $admin = Admin::where('user_id', $user->id)->first();
        if ($admin->admin_photo && Storage::disk('public')->exists('admin_photos/' . $admin->admin_photo)) {
            Storage::disk('public')->delete('admin_photos/' . $admin->admin_photo);
        }

        try {
            $photo = $request->file('admin_photo');
            $photoName = time() . '_' . $user->id . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('admin_photos', $photoName, 'public');

            $admin->update([
                'admin_photo' => $photoName
            ]);

            return redirect()->route('admin.profile')->with('success', 'Foto profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('admin.profile')->with('error', 'Terjadi kesalahan saat mengunggah foto. Silakan coba lagi.');
        }
    }
}
