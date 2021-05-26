<?php
declare(strict_types=1);

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StocksController;
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

Route::view('/', 'welcome');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('accounts', AccountsController::class)
        ->only([
            'create',
            'store',
            'show'
        ]);
    Route::resource('accounts.transactions', TransactionsController::class)
        ->only([
            'create',
            'store'
        ]);
    Route::resource('accounts.stocks', StocksController::class)
        ->only([
            'create',
            'store',
            'update',
            'destroy'
        ]);
    Route::get('/stocks/{symbol}/search', [StocksController::class, 'search']);
    Route::get('/code/{account}', [TransactionsController::class, 'askCode']);
});

