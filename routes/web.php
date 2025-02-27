<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;

// Products index
Route::get('/', [DashboardController::class, 'showProductsDashboard'])->name('dashboard.unath');

// Authorized routes
Route::middleware('auth')->group(function () {
	Route::get('dashboard', [DashboardController::class, 'showAuthorizedDashboard'])->name('dashboard');

	// Products resource
	Route::resource('products', ProductController::class);
});

require __DIR__.'/auth.php';
