<?php

use App\Modules\Authentication\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return response(null, 401);
})->name('login');

Route::prefix('auth')->group(function () {
    Route::post('/create', [AuthController::class, 'create']);
    Route::patch('/verify-email', [AuthController::class, 'verifyEmail']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/resend-verification-email', [AuthController::class, 'resendVerificationEmail']);
});

Route::middleware(['auth:sanctum', 'abilities:refresh'])->group(function () {
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);
});

Route::middleware(['auth:sanctum', 'abilities:auth'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
