<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    /**
     * Display dosen dashboard.
     */
    public function index()
    {
        $dosen = Auth::user()->dosen;
        return view('dosbim.index', compact('dosen'));
    }
}