<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Guest\AdController as GuestAdController;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Admin\AccountController;
Route::get('/', [HomeController::class,'index'])->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {


    Route::resource('/ads', AdController::class);

    // account
     Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');
});

Route::prefix('/ads')->group(function () {
    Route::get('/', [GuestAdController::class, 'index'])->name('website.ads.index');
    Route::get('/{id}', [GuestAdController::class, 'show'])->name('website.ads.show')->whereNumber('id');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
