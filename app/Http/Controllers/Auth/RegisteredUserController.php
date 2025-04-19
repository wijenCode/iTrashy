<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @param string $role
     * @return View
     */
    public function create(string $role): View
    {
        // Validasi role agar hanya bisa menjadi 'user', 'admin', atau 'driver'
        if (!in_array($role, ['user', 'admin', 'driver'])) {
            abort(404); // Menampilkan halaman 404 jika role tidak valid
        }

        // Mengirimkan role ke view agar bisa dipakai untuk menentukan input tersembunyi
        return view('auth.register', compact('role'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @param string $role
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, string $role): RedirectResponse
    {
        // Validasi inputan
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'no_telepon' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required'],
        ]);

        // Tentukan role berdasarkan parameter URL
        if (!in_array($role, ['user', 'admin', 'driver'])) {
            abort(404); // Menampilkan halaman 404 jika role tidak valid
        }

        // Buat user baru dengan role yang ditentukan
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'password' => Hash::make($request->password),
            'role' => $role,  // Menetapkan role berdasarkan URL
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Arahkan ke halaman yang sesuai berdasarkan role
        if ($role === 'user') {
            return redirect()->route('dashboard'); // Misalnya, halaman dashboard user
        } elseif ($role === 'driver') {
            return redirect()->route('driver-dashboard'); // Misalnya, halaman dashboard driver
        } else {
            return redirect()->route('admin.dashboard'); // Misalnya, halaman dashboard admin
        }
    }
}
