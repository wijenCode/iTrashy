<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SetorSampahController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
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
});