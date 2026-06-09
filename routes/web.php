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

    // Dashboard cajero
    Route::get('/cajero', \App\Http\Controllers\CajeroDashboardController::class)
        ->name('cajero.dashboard');
    
    // Clientes
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);

    // Ventas
    Route::resource('sales', \App\Http\Controllers\SaleController::class)->except(['destroy']);
    Route::get('/sales/{sale}/ticket', [\App\Http\Controllers\SaleController::class, 'ticket'])
        ->name('sales.ticket');
    Route::delete('/sales/{sale}', [\App\Http\Controllers\SaleController::class, 'destroy'])
        ->name('sales.destroy')
        ->middleware('role:admin');

    // Caja
    Route::get('/cash', [\App\Http\Controllers\CashRegisterController::class, 'index'])->name('cash.index');
    Route::post('/cash/open', [\App\Http\Controllers\CashRegisterController::class, 'open'])->name('cash.open');
    Route::post('/cash/movements', [\App\Http\Controllers\CashRegisterController::class, 'storeMovement'])
        ->name('cash.movements.store');
    Route::post('/cash/close', [\App\Http\Controllers\CashRegisterController::class, 'close'])->name('cash.close');
    });

require __DIR__.'/auth.php';
