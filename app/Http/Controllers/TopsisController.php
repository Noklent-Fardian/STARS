<?php

namespace App\Http\Controllers;

use App\Services\TopsisService;

class TopsisController extends Controller
{
    public function rekomendasi(TopsisService $topsis)
    {
        $top5 = $topsis->hitungRekomendasi();
        return view('mahasiswa.rekomendasi', compact('top5'));
    }
}