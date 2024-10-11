<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::resource('settings', SettingController::class)->only(['index', 'store']);
    Route::resource('people', PersonController::class)->only(['index', 'store', 'update']);
    Route::resource('transactions', TransactionController::class)->only(['index', 'store']);
    Route::resource('accounts', AccountController::class)->except(['create', 'show']);

    Route::post('people/set-partners-percentage', [PersonController::class, 'setPartnersPercentage'])
        ->name('setPartnersPercentage');
});

