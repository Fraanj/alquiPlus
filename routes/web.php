<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//agrego nahu homecontroller la ruta /home
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\MaquinariaController;

Route::get('/maquinarias/CrearMaquina', [MaquinariaController::class, 'create']);
Route::post('/maquinarias', [MaquinariaController::class, 'store']);
Route::get('/maquinarias/{id}', [MaquinariaController::class, 'show'])->name('maquinarias.show');

require __DIR__.'/auth.php';