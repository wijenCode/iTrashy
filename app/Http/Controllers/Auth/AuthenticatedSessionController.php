<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
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
        // Autentikasi pengguna
        $request->authenticate();
    
        // Regenerasi session untuk mencegah session fixation attack
        $request->session()->regenerate();
    
        // Cek role pengguna setelah login
        if (auth()->user()->role === 'admin') {
            // Redirect ke halaman admin dashboard
            return redirect()->intended(route('admin.dashboard'));
        } else if (auth()->user()->role === 'driver') {
            // Redirect ke halaman user dashboard
            return redirect()->intended(route('driver.ambil.sampah'));
        } else {
            return redirect()->intended(route('dashboard.index')); // Ganti dengan URL yang sesuai
        }
    }
    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
