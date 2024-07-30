<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('riwayat_presensi');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    //     SELECT 
    // (TIME_TO_SEC(TIMEDIFF('15:15:00', '12:15:00')) / 60) / (TIME_TO_SEC('00:45:00') / 60) AS result;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function read()
    {
        $data = User::get();

        return view('guru.riwayat_presensi', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
