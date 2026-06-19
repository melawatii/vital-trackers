<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VitalCategoryController;
use App\Http\Controllers\VitalRecordController;
use App\Http\Controllers\VitalTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Application web routes.
|
*/

/**
 * Redirect root URL.
 */

Route::redirect('/', '/dashboard');

Route::middleware(['auth'])->group(function () {

    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');

    // Master data routes (admin only)
    Route::middleware(['role:admin'])->group(function () {
        // Vital Categories routes
        Route::get('vital-categories/datatable', [VitalCategoryController::class, 'datatable'])->name('vital-categories.datatable');
        Route::resource('vital-categories', VitalCategoryController::class);

        // Vital Types routes
        Route::get('vital-types/datatable', [VitalTypeController::class, 'datatable'])->name('vital-types.datatable');
        Route::resource('vital-types', VitalTypeController::class);

        // Users routes
        Route::get('users/datatable', [UserController::class, 'datatable'])->name('users.datatable');
        Route::resource('users', UserController::class);
    });

    // Vital Records routes
    Route::get('vital-records/datatable', [VitalRecordController::class, 'datatable'])->name('vital-records.datatable');
    Route::get('vital-records/types-by-category', [VitalRecordController::class, 'typesByCategory'])->name('vital-records.types-by-category');
    Route::resource('vital-records', VitalRecordController::class);

});

/**
 * Authentication routes.
 */
require __DIR__ . '/auth.php';
