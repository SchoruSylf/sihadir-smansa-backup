<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nomor_induk'       => ['required'],
            'password'          => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $data_pengguna = DB::table('users')
                ->where('nomor_induk', $request->nomor_induk)
                ->first();

            session([
                'id' => $data_pengguna->id,
                'nomor_induk' => $data_pengguna->nomor_induk,
                'name' => $data_pengguna->name,
                'role' => $data_pengguna->role,
            ]);
            return redirect()->route('user.dashboard');
        } else {
            return redirect()->route('masuk')->with('failed', 'Nomor induk atau kata sandi salah');
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function logout(Request $request)
    {
        Session::flush();
        $request->session()->regenerate();
        Auth::logout();
        return redirect()->route('masuk')->with('success', "Anda berhasil logout");
    }
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
    public function show(LoginController $loginController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoginController $loginController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoginController $loginController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoginController $loginController)
    {
        //
    }
}
