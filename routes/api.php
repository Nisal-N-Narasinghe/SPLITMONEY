<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\SettlementController;
use App\Http\Controllers\Api\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — SplitMoney
|--------------------------------------------------------------------------
| All routes are prefixed with /api automatically by Laravel.
|
| Authentication: Token-based via Laravel Sanctum.
| Include header:  Authorization: Bearer {token}
|--------------------------------------------------------------------------
*/

// ── Auth (public) ──────────────────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
});

// ── Authenticated routes ───────────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me',      [AuthController::class, 'me']);

    // Users (for member selection when creating groups)
    Route::get('/users', [GroupController::class, 'users']);

    // Groups
    Route::get('/groups',          [GroupController::class, 'index']);
    Route::post('/groups',         [GroupController::class, 'store']);
    Route::get('/groups/{group}',  [GroupController::class, 'show']);
    Route::delete('/groups/{group}', [GroupController::class, 'destroy']);

    // Expenses
    Route::get('/groups/{group}/expenses', [ExpenseController::class, 'index']);
    Route::post('/expenses',               [ExpenseController::class, 'store']);

    // Settlements
    Route::get('/groups/{group}/settlements', [SettlementController::class, 'index']);
    Route::post('/settlements',               [SettlementController::class, 'store']);

    // ── Admin routes ───────────────────────────────────────────────────────
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/dashboard',          [AdminController::class, 'dashboard']);
        Route::get('/users',              [AdminController::class, 'users']);
        Route::delete('/users/{user}',    [AdminController::class, 'deleteUser']);
        Route::get('/groups',             [AdminController::class, 'groups']);
        Route::delete('/groups/{group}',  [AdminController::class, 'deleteGroup']);
    });
});
