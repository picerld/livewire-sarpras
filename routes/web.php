<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Items\InItemController;
use App\Http\Controllers\Items\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Unit\UnitController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view("pages.welcome.index");
})->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // admin
    Route::group(['prefix' => '/admin', 'middleware' => ['can:isAdmin']], function() {
        Route::get('/', AdminController::class)->name('admin');
    });

    // petugas
    Route::group(['prefix' => '/pengawas', 'middleware' => ['can:isPengawas']], function() {
        Route::get('/', AdminController::class)->name('pengawas');
    });

    // unit
    Route::group(['prefix' => '/unit', 'middleware' => ['can:isUnit']], function() {
        Route::get('/', UnitController::class)->name('unit');
    });

    // items
    Route::middleware(['can:isAdmin'])->group(function () {
        Route::resource('items', ItemController::class);
        Route::resource('in-items', InItemController::class);
    });
});

// Users will be redirected to this route if not logged in
Volt::route('/login', 'login')->name('login');
 
// Define the logout
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
 
    return redirect('/');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';