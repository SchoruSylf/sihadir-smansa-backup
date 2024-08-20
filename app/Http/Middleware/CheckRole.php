<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $roleMapping = [
            'admin' => 1,
            'guru' => 2,
            'siswa' => 3,
        ];

        $userRole = Auth::user()->role;

        foreach ($roles as $role) {
            if ($roleMapping[$role] == $userRole) {
                return $next($request);
            }
        }

        // Flash error message to session and redirect back
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
    }
}
