<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VitalCategoryController;

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
    Route::redirect('/', '/dashboard');

    // Server-side DataTable data endpoint (must be before resource to avoid conflict)
    Route::get('vital-categories/data', [VitalCategoryController::class, 'data'])
        ->name('vital-categories.data');

    // Full CRUD resource routes
    Route::resource('vital-categories', VitalCategoryController::class);
});

/**
 * Authentication routes.
 */
require __DIR__ . '/auth.php';
