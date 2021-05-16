<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::prefix('account')->group(function () {
        Route::post('create', [AccountsController::class, 'create']);
        Route::get('{id}', [AccountsController::class, 'show']);
//        Route::post('/payment', [AccountsController::class, 'payment']);
        Route::prefix('show-form')->group(function () {
            Route::get('create', [AccountsController::class, 'showCreateForm']);
//            Route::get('rename', [WalletsController::class, 'showRenameForm']);
//            Route::get('delete', [WalletsController::class, 'showDeleteForm']);
        });
    });

    Route::prefix('transaction')->group(function () {
        Route::post('add', [TransactionsController::class, 'payment']);
//        Route::patch('fraudulent', [TransactionsController::class, 'toggleFraudulent']);
//        Route::delete('delete', [TransactionsController::class, 'delete']);
        Route::prefix('show-form')->group(function () {
            Route::get('add', [TransactionsController::class, 'showMakePaymentForm']);
//            Route::get('delete', [TransactionsController::class, 'showDeleteForm']);
        });
    });
});

