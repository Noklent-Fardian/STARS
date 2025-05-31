<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lomba;

class LombaController extends Controller
{
    public function lombaIndex()
    {
        $lombas = Lomba::with(['tingkatan', 'semester', 'keahlians'])
            ->where('lomba_visible', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // Check user role and return appropriate view
        if (auth()->user()->user_role === 'Dosen') {
            return view('dosbim.lomba.index', compact('lombas'));
        } else {
            return view('mahasiswa.lomba.index', compact('lombas'));
        }
    }

    public function lombaShow($id)
    {
        $lomba = Lomba::with(['tingkatan', 'semester', 'keahlians'])
            ->where('lomba_visible', true)
            ->findOrFail($id);

        // Check user role and return appropriate view
        if (auth()->user()->user_role === 'Dosen') {
            return view('dosbim.lomba.show', compact('lomba'));
        } else {
            return view('mahasiswa.lomba.show', compact('lomba'));
        }
    }

    public function daftarLomba(Request $request) {}

    public function createAjax() {}

    public function storeAjax(Request $request)
    {
        // Implementation for storing new competition via AJAX
    }
}
