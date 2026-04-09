<?php

use Illuminate\Support\Facades\Route;

// Ruta principal
Route::get('/', function(){
    return redirect()->route('login');
});

// Rutas solo para admin
Route::middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)
    ->name('dashboard');
    // Categorias
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    
    // Productos
    Route::resource('products', \App\Http\Controllers\ProductController::class);

    // Usuarios
    Route::resource('users', \App\Http\Controllers\UserController::class);

    // Reportes
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])
        ->name('reports.index');
});

// Rutas para admin y cajero
Route::middleware(['auth'])->group(function() {
    Route::get('/profile', function() {
        return view('profile');
    })->name('profile');
    
    // Clientes
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);

    // Ventas
    Route::resource('sales', \App\Http\Controllers\SaleController::class);

    // Caja
    Route::get('/cash', function() {
        return view('cash.index');
    })->name('cash.index');
});

require __DIR__.'/auth.php';
