<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Rutas para usuarios comunes (reservas, etc.)
    // Route::get('/mis-reservas', [ReservaController::class, 'index'])->name('reservas.index');
    Route::get('/reservas', [ReservaController::class, 'form'])->name('reservas.form');
    Route::post('/reservas', [ReservaController::class, 'create'])->name('reservas.create');
    Route::get('/reservas/pago', [ReservaController::class, 'pago'])->name('reservas.pago');
    Route::post('/reservas/pago', [ReservaController::class, 'pago'])->name('reservas.confirmarPago');
});
// Rutas para empleados y administradores
Route::middleware(['auth', 'role:employee,admin'])->group(function () {
    // Route::resource('maquinarias', MaquinariaController::class);
});

use App\Http\Controllers\MaquinariaController;

Route::get('/maquinarias/CrearMaquina', [MaquinariaController::class, 'create'])->name('maquinarias.create');
Route::post('/maquinarias', [MaquinariaController::class, 'store']);
Route::get('/maquinarias/{id}', [MaquinariaController::class, 'show'])->name('maquinarias.show');

require __DIR__.'/auth.php';
