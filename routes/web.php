<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SetorSampahController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\EdukasiUserController;
use App\Http\Controllers\PencapaianController;
use App\Http\Controllers\SembakoController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TukarPoinController;

// Rute untuk logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login'); // Redirect ke halaman login setelah logout
})->name('logout');

// Rute untuk halaman profil pengguna
Route::middleware(['auth'])->get('/profile', [UserController::class, 'show'])->name('profile');

Route::middleware(['auth'])->group(function () {

    // Rute untuk admin dashboard
    // Route::get('/admin/dashboard', function () {
    //     if (auth()->check() && auth()->user()->role !== 'admin') {
    //         return redirect('/home'); // Redirect ke halaman lain jika bukan admin
    //     }
    //     return view('admin.dashboard.index'); // Tampilkan dashboard admin
    // })->name('admin.dashboard');

    // Rute untuk manajemen katalog jenis sampah
    Route::prefix('admin/jenis-sampah')->name('admin.jenis-sampah.')->group(function () {
        Route::get('/', [JenisSampahController::class, 'index'])->name('index'); // Halaman index
        Route::get('/create', [JenisSampahController::class, 'create'])->name('create'); // Form create
        Route::post('/', [JenisSampahController::class, 'store'])->name('store'); // Simpan data
        Route::get('/{jenisSampah}/edit', [JenisSampahController::class, 'edit'])->name('edit'); // Form edit
        Route::put('/{jenisSampah}', [JenisSampahController::class, 'update'])->name('update'); // Update data
        Route::delete('/{jenisSampah}', [JenisSampahController::class, 'destroy'])->name('destroy'); // Hapus data
    });
});

Route::get('/', function () {
    return view('index'); // View file for the landing page
});

Route::middleware('auth')->group(function () {
    Route::get('/setor-sampah', [SetorSampahController::class, 'index'])->name('setor.sampah');
    Route::post('/setor-sampah', [SetorSampahController::class, 'store'])->name('setor.sampah.store');

    Route::get('/tukar-poin', [TukarPoinController::class, 'index'])->name('tukar_poin.index');
    Route::get('/voucher/{id}', [VoucherController::class, 'show'])->name('voucher.detail');
    Route::get('/sembako/{id}', [SembakoController::class, 'show'])->name('sembako.detail');

    Route::get('/donasi', [DonasiController::class, 'index'])->name('donasi.index');
    Route::get('/transfer', [TransferController::class, 'index'])->name('transfer.index');
});

// Route untuk menampilkan form login (GET request)
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

// Route untuk memproses login (POST request)
Route::post('login', [AuthenticatedSessionController::class, 'store']);

// Route untuk logout
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/solusi', function () {
    return view('landing.solusi');
})->name('solusi');

Route::get('/fitur', function () {
    return view('landing.fitur');
})->name('fitur');

Route::get('/tentang', function () {
    return view('landing.tentang');
})->name('tentang');

// Route untuk registrasi
Route::get('register/{role}', [RegisteredUserController::class, 'create'])->name('register.show');
Route::post('register/{role}', [RegisteredUserController::class, 'store'])->name('register.store');

// Route untuk dashboard masing-masing role
Route::middleware('auth')->group(function () {
    // Driver Dashboard
    Route::get('/driver/dashboard', function () {
        return view('driver-dashboard'); // Halaman khusus driver
    })->name('driver-dashboard');

    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard.index'); // Halaman khusus admin
    })->name('admin.dashboard');

    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

// Rute untuk halaman profil pengguna
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroy'])->name('profile.destroy');
});

// Edukasi User Routes
Route::get('/edukasi', [EdukasiUserController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{id}', [EdukasiUserController::class, 'show'])->name('edukasi.show');
Route::get('/edukasi/kategori/{kategori}', [EdukasiUserController::class, 'kategori'])->name('edukasi.kategori');
Route::get('/edukasi/jenis/{jenis}', [EdukasiUserController::class, 'jenisKonten'])->name('edukasi.jenis');

// Pencapaian routes
Route::get('/pencapaian', [PencapaianController::class, 'index'])->name('user.pencapaian.index');

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