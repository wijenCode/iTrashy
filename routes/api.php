<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SetorSampahController;
use App\Http\Controllers\Api\EdukasiController;
use App\Http\Controllers\Api\RiwayatController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\TransferController;
use App\Http\Controllers\Api\TukarPoinController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes (no authentication required)
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// Protected routes (authentication required)
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('logout-all', [AuthController::class, 'logoutAll']);
    });

    // Setor Sampah routes
    Route::prefix('setor-sampah')->group(function () {
        // Get jenis sampah (semua role bisa akses)
        Route::get('jenis-sampah', [SetorSampahController::class, 'getJenisSampah']);
        
        // CRUD operations
        Route::get('/', [SetorSampahController::class, 'index']); // GET /api/setor-sampah
        Route::post('/', [SetorSampahController::class, 'store']); // POST /api/setor-sampah (user only)
        Route::get('/{id}', [SetorSampahController::class, 'show']); // GET /api/setor-sampah/{id}
        Route::put('/{id}', [SetorSampahController::class, 'update']); // PUT /api/setor-sampah/{id} (user only)
        Route::delete('/{id}', [SetorSampahController::class, 'destroy']); // DELETE /api/setor-sampah/{id} (user & admin)
        
        // Driver specific actions
        Route::post('/{id}/ambil', [SetorSampahController::class, 'ambil']); // POST /api/setor-sampah/{id}/ambil (driver only)
        Route::post('/{id}/selesai', [SetorSampahController::class, 'selesai']); // POST /api/setor-sampah/{id}/selesai (driver only)
        Route::post('/{id}/tolak', [SetorSampahController::class, 'tolak']); // POST /api/setor-sampah/{id}/tolak (driver & admin)
    });

    // Riwayat API Routes
    Route::get('/riwayat', [RiwayatController::class, 'index']);
    Route::get('/riwayat/{type}/{id}', [RiwayatController::class, 'show']);

// Edukasi API Routes
Route::prefix('edukasi')->group(function () {
    Route::get('/', [EdukasiController::class, 'index']);
    Route::get('/{id}', [EdukasiController::class, 'show']);
    Route::get('/category/{category}', [EdukasiController::class, 'byCategory']);
    Route::get('/type/{type}', [EdukasiController::class, 'byType']);
    Route::get('/categories', [EdukasiController::class, 'categories']);
    Route::get('/types', [EdukasiController::class, 'types']);
    Route::get('/search', [EdukasiController::class, 'search']);
    });

    // Notifikasi API untuk user
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::post('/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);
        Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
        Route::get('/unread-count', [NotificationController::class, 'unreadCount']);
    });

    // Routes for Transfer API
    Route::post('transfer-poin', [TransferController::class, 'transferPoin']);

    // Routes for Tukar Poin API
    Route::prefix('tukar-poin')->group(function () {
        Route::get('/', [TukarPoinController::class, 'index']);
        Route::post('/voucher/{id}/tukar', [TukarPoinController::class, 'tukarVoucher']);
        Route::post('/sembako/{id}/tukar', [TukarPoinController::class, 'tukarSembako']);
    });
});