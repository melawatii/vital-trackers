<?php

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

Route::middleware(['auth'])->group(function () {

    // Dashboard route
    Route::redirect('/', '/dashboard');
    Route::get('/dashboard', function () { return view('dashboard.index'); })->name('dashboard');

    // Vital Categories routes
    Route::get('vital-categories/datatable', [VitalCategoryController::class, 'datatable'])->name('vital-categories.datatable');
    Route::resource('vital-categories', VitalCategoryController::class);

    // Vital Types routes
    Route::get('vital-types/datatable', [App\Http\Controllers\VitalTypeController::class, 'datatable'])->name('vital-types.datatable');
    Route::resource('vital-types', VitalTypeController::class);

    // Vital Records routes
    Route::get('vital-records/datatable',       [App\Http\Controllers\VitalRecordController::class, 'datatable'])->name('vital-records.datatable');
    Route::get('vital-records/types-by-category', [App\Http\Controllers\VitalRecordController::class, 'typesByCategory'])->name('vital-records.types-by-category');
    Route::resource('vital-records', App\Http\Controllers\VitalRecordController::class);

});

/**
 * Authentication routes.
 */
require __DIR__ . '/auth.php';
