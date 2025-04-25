<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPegawaiController extends Controller
{
    /**
     * Tampilkan halaman landing untuk pegawai.
     */
    public function index()
    {
        return view('landing_pegawai');
    }
}
