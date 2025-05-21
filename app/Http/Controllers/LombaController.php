<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LombaController extends Controller
{
    public function lombaIndex()
    {
         $page = (object) [
            'title' => 'Data Lomba',
        ];
        return view('lomba.index', compact('page'));
    }

    public function lombaShow($id)
    {
    }

    public function daftarLomba(Request $request)
    {
    }

    public function createAjax()
    {
    }

    public function storeAjax(Request $request)
    {
    }
}
