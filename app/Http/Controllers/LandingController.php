<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('landing', compact('banners'));
    }
    
    public function login()
    {
        return view('auth.login');
    }
}