<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('admin.admin.index');
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
        return view('admin.lomba.index');
    }


    public function masterPeriode()
    {
        return view('admin.master.periode');
    }

    public function masterProdi()
    {
        return view('admin.master.prodi');
    }
    public function masterKeahlian()
    {
        return view('admin.master.keahlian');
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
}
