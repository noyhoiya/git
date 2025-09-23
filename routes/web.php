<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VaultController;
use App\Http\Controllers\CashRequestController;
use App\Http\Controllers\VaultMovementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\CashRequestPdfController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (auth middleware)
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Cash Requests
    Route::resource('cash-requests', CashRequestController::class);
    Route::post('/cash-requests/{id}/approve', [CashRequestController::class, 'approve'])
        ->name('cash-requests.approve');
    Route::post('/cash-requests/{id}/reject', [CashRequestController::class, 'reject'])
        ->name('cash-requests.reject');
        // routes/web.php


Route::get('/cash-requests/{id}/pdf', [CashRequestPdfController::class, 'show'])
    ->name('cash-requests.pdf');
// routes/web.php
Route::get('/cash-requests', [CashRequestController::class, 'index'])->name('cash-requests.index');



    // Vault Movements
    Route::resource('vault-movements', VaultMovementController::class);
    Route::post('/vault-movements/{id}/post', [VaultMovementController::class, 'postMovement'])
        ->name('vault-movements.postMovement');
    Route::delete('/vault-movements/{id}', [VaultMovementController::class, 'destroy'])->name('vault-movements.destroy');

//FOR EXPORT
        Route::get('/vault-movements/export/excel', [VaultMovementController::class, 'exportExcel'])->name('vault-movements.export.excel');
        Route::get('/vault-movements/export/pdf', [VaultMovementController::class, 'exportPDF'])->name('vault-movements.export.pdf');
        Route::get('/vault-movements/export/word', [VaultMovementController::class, 'exportWord'])->name('vault-movements.export.word');


    // Vaults
    Route::resource('vaults', VaultController::class);
    Route::get('/vaults/{id}/balance', [VaultController::class, 'getBalance'])
        ->name('vaults.balance');
        // web.php
Route::post('/vault/handover-debug', [VaultController::class, 'handoverDebug']);
Route::get('/vault/debug-logs', [VaultController::class, 'showDebugLogs']);




    // User Management (Admin only)
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});


    // Reports
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
    Route::get('/reports/cash-flow', [DashboardController::class, 'cashFlowReport'])->name('reports.cashFlow');

    //Email
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
     ->middleware(['auth', 'throttle:6,1'])
     ->name('verification.send');
     Route::get('/email/verify', EmailVerificationPromptController::class)
    ->middleware('auth')
    ->name('verification.notice');
// routes/web.php

Route::post('/dismiss-cash-alert', function (\Illuminate\Http\Request $request) {
    $id = $request->input('id'); // id of the alert to remove
    $alerts = session('cash_request_alerts', []);

    // Keep all alerts except the one with the clicked ID
    $alerts = array_filter($alerts, fn($alert) => $alert['id'] != $id);

    // Save back to session
    session(['cash_request_alerts' => array_values($alerts)]);

    return response()->json(['status' => 'success']);
})->name('dismiss.cash.alert');


    // ER & Process Diagrams
    Route::get('/er-diagram', fn() => view('diagrams.er-diagram'))->name('er-diagram');
    Route::get('/process-diagram', fn() => view('diagrams.process-diagram'))->name('process-diagram');
});

