<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettlementController;
use App\Http\Controllers\TripPlannerController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/aboutus', [DashboardController::class, 'aboutus'])->name('aboutus');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard']);
    Route::get('/users', [AdminController::class, 'users']);
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser']);
    Route::get('/groups', [AdminController::class, 'groups']);
    Route::delete('/groups/{group}', [AdminController::class, 'deleteGroup']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/trip-planner', [TripPlannerController::class, 'index']);
    Route::post('/trip-planner/plan', [TripPlannerController::class, 'plan']);
    Route::post('/trip-planner/create-group', [TripPlannerController::class, 'createGroup']);

    Route::get('/groups/create', [GroupController::class, 'create']);
    Route::post('/groups', [GroupController::class, 'store']);
    Route::get('/groups/{group}', [GroupController::class, 'show']);
    Route::delete('/groups/{group}', [GroupController::class, 'destroy']);

    Route::get('/expenses/create/{group}', [ExpenseController::class, 'create']);
    Route::post('/expenses', [ExpenseController::class, 'store']);

    Route::get('/settlements/create/{group}', [SettlementController::class, 'create']);
    Route::post('/settlements', [SettlementController::class, 'store']);
});
