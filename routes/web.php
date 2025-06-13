<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaquinariaController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para usuarios comunes (reservas, etc.)
    Route::get('/reservas', [ReservaController::class, 'form'])->name('reservas.form');
    Route::post('/reservas', [ReservaController::class, 'create'])->name('reservas.create');
    Route::get('/reservas/pago', [ReservaController::class, 'pago'])->name('reservas.pago');
    Route::post('/reservas/pago', [ReservaController::class, 'pago'])->name('reservas.confirmarPago');

    // 🔄 RUTAS DE CALLBACK DE MERCADOPAGO (sin middleware auth)
});

// 🌐 RUTAS PÚBLICAS PARA MERCADOPAGO (fuera del middleware auth)
Route::get('/pago/exitoso', [ReservaController::class, 'success'])->name('pago.exitoso');
Route::get('/pago/fallido', [ReservaController::class, 'failure'])->name('pago.fallido');
Route::get('/pago/pendiente', [ReservaController::class, 'pending'])->name('pago.pendiente');

// Rutas para empleados
Route::middleware(['auth', 'role:employee'])->group(function () {
    // Rutas para empleados
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/maquinarias/CrearMaquina', [MaquinariaController::class, 'create'])->name('maquinarias.create');
    Route::post('/maquinarias', [MaquinariaController::class, 'store']);
    Route::get('/maquinarias/{id}/edit', [MaquinariaController::class, 'edit'])->name('maquinarias.edit');
    Route::put('/maquinarias/{id}', [MaquinariaController::class, 'update'])->name('maquinarias.update');
    Route::get('/maquinarias/{id}/delete', [MaquinariaController::class, 'confirmDelete'])->name('maquinarias.confirmDelete');
    Route::delete('/maquinarias/{id}/delete', [MaquinariaController::class, 'destroy'])->name('maquinarias.destroy');
    Route::get('/maquinarias/{id}/restore', [MaquinariaController::class, 'restore'])->name('maquinarias.restore');
});

Route::get('/maquinarias/{id}', [MaquinariaController::class, 'show'])->name('maquinarias.show');

require __DIR__ . '/auth.php';
