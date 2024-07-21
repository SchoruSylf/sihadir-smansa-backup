<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Assuming $data_pengguna is passed via route parameters
        $data_pengguna = $request->data_pengguna;

        // Or if it's coming from the authenticated user, you might do something like this:
        // $data_pengguna = $request->user(); // If using Auth::user() for example
            // return dd(compact('data_pengguna'));
        return view('dashboard');
    }
}
