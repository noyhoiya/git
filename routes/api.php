<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CashRequestController;
use App\Http\Controllers\Api\VaultMovementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// API Authentication
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

// Protected API Routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Dashboard API
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
    Route::get('/dashboard/recent-transactions', [DashboardController::class, 'getRecentTransactions']);
    
    // Cash Requests API
    Route::apiResource('cash-requests', CashRequestController::class);
    Route::post('/cash-requests/{id}/approve', [CashRequestController::class, 'approve']);
    Route::post('/cash-requests/{id}/reject', [CashRequestController::class, 'reject']);
    
    // Vault Movements API
    Route::apiResource('vault-movements', VaultMovementController::class);
    Route::post('/vault-movements/{id}/post', [VaultMovementController::class, 'postMovement']);
    
    // Vault Status API
    Route::get('/vaults', function () {
        return \App\Models\Vault::where('is_active', true)->get();
    });
    
    Route::get('/vaults/{id}/balance', function ($id) {
        $vault = \App\Models\Vault::findOrFail($id);
        return response()->json([
            'vault_id' => $vault->vault_id,
            'current_balance_cents' => $vault->current_balance_cents,
            'current_balance' => $vault->current_balance_cents / 100
        ]);
    });
});