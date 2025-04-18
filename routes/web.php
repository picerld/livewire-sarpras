<?php

use Livewire\Volt\Volt;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Items\CategoryController;
use App\Http\Controllers\Items\InItemController;
use App\Http\Controllers\Items\ItemController;
use App\Http\Controllers\Items\OutItemController;
use App\Http\Controllers\Items\StockController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Request\RequestController;
use App\Http\Controllers\Submission\SubmissionController;
use App\Http\Controllers\Supplier\SupplierController;
use App\Http\Controllers\Unit\CartController;
use App\Http\Controllers\Unit\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view("pages.welcome.index");
})->name('dashboard');

// route for search
Route::get('/spotlight/search', [\App\Support\Spotlight::class, 'search'])
    ->name('spotlight.search')
    ->middleware(['auth']);
    
Route::middleware(['auth'])->group(function () {
    // route for admin
    Route::group(['prefix' => '/admin', 'middleware' => ['can:isAdmin']], function () {
        Route::get('/', AdminController::class)->name('admin');
    });

    // route for petugas
    Route::group(['prefix' => '/pengawas', 'middleware' => ['can:isPengawas']], function () {
        Route::get('/', AdminController::class)->name('pengawas');
    });

    // route for unit
    Route::group(['prefix' => '/unit', 'middleware' => ['can:isUnit']], function () {
        Route::get('/', UnitController::class)->name('unit');
    });

    // route for admin
    Route::middleware(['can:isAdmin'])->group(function () {
        Route::resource('in-items', InItemController::class);
        Route::post('/in-item/export', [InItemController::class, 'export'])->name('in-items.export');

        Route::resource('category', CategoryController::class);
        Route::resource('users', UserController::class);
        Route::resource('stock', StockController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('employees', EmployeeController::class);

        // laporan
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
        Route::post('/report/export/{id}', [ReportController::class, 'export'])->name('report.export');
    });

    // route for submission 'pengawas or admin'
    // Route::middleware(['can:createTransaction'])->group(function () {
    // });
    
    Route::resource('requests', RequestController::class);
    Route::post('/request/export', [RequestController::class, 'export'])->name('requests.export');
    Route::resource('submissions', SubmissionController::class);
    Route::post('/submission/export', [SubmissionController::class, 'export'])->name('submissions.export');

    // Route::middleware(['can:isAdmin'])->group(function () {
    // route for admin and pengawas
    Route::resource('items', ItemController::class);
    Route::get('/item/export', [ItemController::class, 'export'])->name('items.export');
    Route::get('/item/import', [ItemController::class, 'import'])->name('items.import');

    Route::resource('out-items', OutItemController::class);
    Route::post('/out-item/export', [OutItemController::class, 'export'])->name('out-items.export');
    // });

    Route::middleware(['can:isUnit'])->group(function () {
        Route::resource('carts', CartController::class);
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

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
