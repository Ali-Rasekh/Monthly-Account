<?php

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
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::resource('dashboard/settings', SettingController::class)->except('show');
Route::resource('dashboard/people', PersonController::class)->except('show');
Route::resource('dashboard/transactions', TransactionController::class)->except('show');


Route::post('dashboard/people/set-partners-percentage', [PersonController::class, 'setPartnersPercentage'])
    ->name('setPartnersPercentage');
