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

        return view('mahasiswa.lomba.index', compact('lombas'));
    }

    public function lombaShow($id)
    {
        $lomba = Lomba::with(['tingkatan', 'semester', 'keahlians'])
            ->where('lomba_visible', true)
            ->findOrFail($id);

        return view('mahasiswa.lomba.show', compact('lomba'));
    }

    public function daftarLomba(Request $request)
    {
        // Implementation for competition registration
    }

    public function createAjax()
    {
        // Implementation for creating new competition via AJAX
    }

    public function storeAjax(Request $request)
    {
        // Implementation for storing new competition via AJAX
    }
}
