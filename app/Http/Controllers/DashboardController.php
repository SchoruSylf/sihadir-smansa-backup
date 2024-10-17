<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data_pengguna = "asd";
        // $value = Session::get('label');
        // Set the locale to Indonesian
        Carbon::setLocale('id');

        // Get the current date and time
        $today = Carbon::now();
        $dayName = $today->locale('id')->translatedFormat('l');
        $currentDate = $today->toDateString();
        $currentTime = $today->toTimeString();

        return view('dashboard', compact('currentDate', 'dayName'));
    }
}
