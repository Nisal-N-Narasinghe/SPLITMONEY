<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettlementController;

Route::get('/', [DashboardController::class, 'index']);

Route::get('/groups/create', [GroupController::class, 'create']);
Route::post('/groups', [GroupController::class, 'store']);
Route::get('/groups/{group}', [GroupController::class, 'show']);
Route::delete('/groups/{group}', [GroupController::class, 'destroy']);

Route::get('/expenses/create/{group}', [ExpenseController::class, 'create']);
Route::post('/expenses', [ExpenseController::class, 'store']);

Route::get('/settlements/create/{group}', [SettlementController::class, 'create']);
Route::post('/settlements', [SettlementController::class, 'store']);
