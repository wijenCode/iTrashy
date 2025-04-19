<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


// Route untuk menampilkan form login (GET request)
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

// Route untuk memproses login (POST request)
Route::post('login', [AuthenticatedSessionController::class, 'store']);

// Route untuk logout
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::get('/', function () {
    return view('welcome');
});

// Route untuk registrasi
Route::get('register/{role}', [RegisteredUserController::class, 'create'])->name('register.show');
Route::post('register/{role}', [RegisteredUserController::class, 'store'])->name('register.store');

// Route untuk dashboard masing-masing role
Route::middleware('auth')->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // Halaman khusus admin
    })->name('admin.dashboard');

    // Driver Dashboard
    Route::get('/driver/dashboard', function () {
        return view('driver-dashboard'); // Halaman khusus driver
    })->name('driver-dashboard');

    // User Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard'); // Halaman khusus user
    })->name('dashboard');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

