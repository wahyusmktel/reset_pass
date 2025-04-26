<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogResetGoogle;

class LogResetGoogleController extends Controller
{
    public function index()
    {
        $logs = LogResetGoogle::latest()->paginate(10); // paginate 10 data per halaman
        return view('log_reset_google.index', compact('logs'));
    }
}
