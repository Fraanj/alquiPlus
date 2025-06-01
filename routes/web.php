<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

//SIN middleware - Cualquiera puede ir a HOME
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Rutas para usuarios comunes (reservas, etc.)
    // Route::get('/mis-reservas', [ReservaController::class, 'index'])->name('reservas.index');
});
// Rutas para empleados y administradores
Route::middleware(['auth', 'role:employee,admin'])->group(function () {
    // Route::resource('maquinarias', MaquinariaController::class);
});

// Rutas solo para administradores
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    // Route::resource('usuarios', UserController::class);
});
require __DIR__.'/auth.php';
