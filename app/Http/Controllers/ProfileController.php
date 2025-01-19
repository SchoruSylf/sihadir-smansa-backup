<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->session()->get("nomor_induk");
        $users = DB::table('users')
            ->where('nomor_induk', '=', $user)
            ->select('id')
            ->get();
        $kelas = DB::table('users')
            ->join('user_kelas', 'users.id', '=', 'user_id')
            ->join('kelas', 'kelas.id', '=', 'kelas_id')
            ->where('nomor_induk', '=', $user)
            ->select(DB::raw('CONCAT(kelas.kelas, " ", kelas.jenis_kelas) as kelas'))
            ->get();

        return view('profile', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show()
    {
        return view('profile');
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
