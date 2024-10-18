<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonthlyProfitController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\checkAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('first');

Route::post('check', [DashboardController::class, 'check'])->name('check-it');

Route::prefix('dashboard')->middleware(checkAdmin::class)->group(function () {
    Route::get('', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('calculate', [DashboardController::class, 'calculate'])->name('calculate');
    Route::get('logout', [DashboardController::class, 'logout'])->name('logout');
    Route::post('', [DashboardController::class, 'store'])->name('dashboard.store');
    Route::resource('settings', SettingController::class)->only(['index', 'store']);
    Route::resource('people', PersonController::class)->only(['index', 'store', 'update']);
    Route::resource('transactions', TransactionController::class)->only(['index', 'store']);
    Route::resource('accounts', AccountController::class)->except(['create', 'show']);
    Route::resource('profits', MonthlyProfitController::class)->except(['create', 'show']);

    Route::post('people/set-partners-percentage', [PersonController::class, 'setPartnersPercentage'])
        ->name('setPartnersPercentage');
});

