<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data_pengguna = "asd";
        
        return view('dashboard', compact('data_pengguna'));
    }
}
