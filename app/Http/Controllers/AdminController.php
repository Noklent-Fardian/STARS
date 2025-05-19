<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

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
        return view('admin.dosenManagement.index');
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
        return view('admin.profile', compact('admin'));
    }
    
    public function editProfile()
    {
        $user = Auth::user();
        $admin = Admin::where('user_id', $user->id)->first();
        return view('admin.edit_profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $admin = Admin::where('user_id', $user->id)->first();
    
        $admin->update([
            'admin_name' => $request->admin_name,
            'admin_nomor_telepon' => $request->admin_nomor_telepon,
            'admin_gender' => $request->admin_gender,
        ]);
    
        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
