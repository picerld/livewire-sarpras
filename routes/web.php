<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserChartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\UserPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // petugas
    Route::group(['prefix' => '/petugas', 'middleware' => ['can:isPetugas']], function() {
        Route::get('/', AdminController::class)->name('petugas');
    });

    // admin
    Route::group(['prefix' => '/admin', 'middleware' => ['can:isAdmin']], function() {
        Route::get('/', AdminController::class)->name('admin');
    });
});

// Route::group(['prefix' => '/petugas', 'middleware' => ['auth', 'can:isPetugas']], function () {
//     Route::get('/', AdminController::class)->name('petugas');

//     Route::resource('/user', UserManageController::class);

//     Route::get('/chart', UserChartController::class)->name('chart');
//     Route::get('/user/pdf', UserPdfController::class)->name('pdf');
// });

Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'can:isAdmin']], function () {
    Route::get('/', AdminController::class)->name('admin');
});

Route::group(['prefix' => '/unit', 'middleware' => ['auth', 'can:isUnit']], function () {
    Route::get('/', UserController::class)->name('unit');
});

Route::get('/barang', function(){
    return view('barang');
})->name('barang');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';