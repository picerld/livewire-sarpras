<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectRoleController extends Controller
{
    public function __invoke()
    {
        // if(!Auth::check()) {
        //     return redirect()->rote('login');
        // }

        $redirectMap = [
            'petugas' => '/petugas',
            'admin' => '/admin',
            'pengawas' => '/petugas',
            'unit' => '/unit'
        ];

        $user = Auth::user();
        
        return redirect($redirectMap[$user->role]);
    }
}
