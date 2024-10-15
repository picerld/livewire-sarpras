<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Mary\Traits\Toast;

class AuthenticatedSessionController extends Controller
{
    use Toast;

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        
        $request->session()->regenerate();

        $role = $request->user()->role;

        if($role == 'admin') {
            return redirect(route('admin'));
        } elseif($role == 'pengawas') {
            return redirect(route('pengawas'));
        }

        $this->success('Login success!', 'Success!', redirectTo: route('unit') , position: 'toast-bottom');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        return redirect(route('dashboard'));
    }
}
