<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\EdukasiUserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PencapaianController;




// Rute untuk logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login'); // Redirect ke halaman login setelah logout
})->name('logout');

// Profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'show'])->name('users.show');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('users.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('users.password.update');
    
    // Pencapaian routes
    Route::get('/pencapaian', [PencapaianController::class, 'index'])->name('users.pencapaian.index');
});




// Menampilkan form login admin
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');

// Menangani proses login admin
Route::post('/admin/login', [AdminLoginController::class, 'login']);
    


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
        return view('admin.dashboard.index'); // Halaman khusus admin
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

// Edukasi User Routes
Route::get('/edukasi', [EdukasiUserController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{id}', [EdukasiUserController::class, 'show'])->name('edukasi.show');
Route::get('/edukasi/kategori/{kategori}', [EdukasiUserController::class, 'kategori'])->name('edukasi.kategori');
Route::get('/edukasi/jenis/{jenis}', [EdukasiUserController::class, 'jenisKonten'])->name('edukasi.jenis');

// Admin Edukasi Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Index - Menampilkan daftar edukasi
    Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
    
    // Create - Menampilkan form untuk membuat edukasi baru
    Route::get('/edukasi/create', [EdukasiController::class, 'create'])->name('edukasi.create');
    
    // Store - Menyimpan edukasi baru
    Route::post('/edukasi', [EdukasiController::class, 'store'])->name('edukasi.store');
    
    // Show - Menampilkan detail edukasi
    Route::get('/edukasi/{id}', [EdukasiController::class, 'show'])->name('edukasi.show');
    
    // Edit - Menampilkan form untuk mengedit edukasi
    Route::get('/edukasi/{id}/edit', [EdukasiController::class, 'edit'])->name('edukasi.edit');
    
    // Update - Mengupdate edukasi
    Route::put('/edukasi/{id}', [EdukasiController::class, 'update'])->name('edukasi.update');
    
    // Destroy - Menghapus edukasi
    Route::delete('/edukasi/{id}', [EdukasiController::class, 'destroy'])->name('edukasi.destroy');
});

require __DIR__.'/auth.php';

