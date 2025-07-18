<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaquinariaController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\EstadisticasController;

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
    Route::get('/reservas/{id}/rembolso', [ReservaController::class, 'confirmarRembolso'])->name('reservas.confirmarRembolso');
    Route::delete('/reservas/{id}/rembolso', [ReservaController::class, 'destroy'])->name('reservas.destroy');
    Route::get('/reservas/pago', [ReservaController::class, 'pago'])->name('reservas.pago');
    Route::post('/reservas/pago', [ReservaController::class, 'pago'])->name('reservas.confirmarPago');

    // esto esta para pruebas de los mails
    // 🔄 RUTAS DE CALLBACK DE MERCADOPAGO (sin middleware auth)
});

// 🌐 RUTAS PÚBLICAS PARA MERCADOPAGO (fuera del middleware auth)
Route::get('/pago/exitoso', [ReservaController::class, 'success'])->name('pago.exitoso');
Route::get('/pago/fallido', [ReservaController::class, 'failure'])->name('pago.fallido');
Route::get('/pago/pendiente', [ReservaController::class, 'pending'])->name('pago.pendiente');

Route::get('/enviarEmail', [MailController::class, 'sendTestEmail'])->name('enviar.email');
Route::get('/enviarPasswordEmail', [MailController::class, 'sendPasswordEmail'])->name('enviar.password.email');
Route::get('/enviarCancelacion', [MailController::class, 'sendCancelacionMantenimientoEmail'])->name('enviar.cancelacion.mantenimiento.email');

// Rutas para empleados
Route::middleware(['auth', 'role:employee'])->group(function () {
    // Rutas para empleados
    Route::get('/maquinarias/{id}/mantenimiento', [MaquinariaController::class, 'maintenanceForm'])->name('maquinarias.maintenance');
    Route::post('/maquinarias/{id}/mantenimiento', [MaquinariaController::class, 'startMaintenance'])->name('maquinarias.startMaintenance');
    Route::get('/maquinarias/{id}/terminarMmantenimiento', [MaquinariaController::class, 'endMaintenance'])->name('maquinarias.endMaintenance');
    Route::get('/historialReservas', [ReservaController::class, 'historialReservas'])->name('reservas.historial');
    Route::get('/reserva/{reserva}/confirmada', [ReservaController::class, 'confirmada']);
    Route::get('/reserva/{reserva}/completada', [ReservaController::class, 'completada']);
    Route::get('/reserva/{reserva}/cancelar', [ReservaController::class, 'cancelar']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/maquinarias/CrearMaquina', [MaquinariaController::class, 'create'])->name('maquinarias.create');
    Route::post('/maquinarias', [MaquinariaController::class, 'store']);
    Route::get('/maquinarias/{id}/edit', [MaquinariaController::class, 'edit'])->name('maquinarias.edit');
    Route::put('/maquinarias/{id}', [MaquinariaController::class, 'update'])->name('maquinarias.update');
    Route::get('/maquinarias/{id}/delete', [MaquinariaController::class, 'confirmDelete'])->name('maquinarias.confirmDelete');
    Route::delete('/maquinarias/{id}/delete', [MaquinariaController::class, 'destroy'])->name('maquinarias.destroy');
    Route::get('/maquinarias/{id}/restore', [MaquinariaController::class, 'restore'])->name('maquinarias.restore');
    Route::get('/estadisticas', [EstadisticasController::class, 'index'])->name('estadisticas');
    Route::get('/estadisticas/monto-facturado', [EstadisticasController::class, 'montoFacturado'])->name('estadisticas.montoFacturado');
    Route::get('/estadisticas/reservas-totales', [EstadisticasController::class, 'reservasTotales'])->name('estadisticas.reservasTotales');
    Route::get('/estadisticas/nuevos-clientes', [EstadisticasController::class, 'nuevosClientes'])->name('estadisticas.nuevos-clientes');
    Route::get('/estadisticas/{tipo}/pdf', [EstadisticasController::class, 'descargarPdf'])
    ->name('estadisticas.pdf')
    ->middleware('auth');
    // Empleados (nuevas rutas)
    Route::get('/empleados', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/empleados/crear', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/empleados', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/empleados/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/empleados/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/empleados/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::patch('/empleados/{employee}/desactivar', [EmployeeController::class, 'deactivate'])->name('employees.desactivar');
    Route::patch('/empleados/{employee}/activar', [EmployeeController::class, 'activate'])->name('employees.activar');
});

Route::get('/maquinarias/{id}', [MaquinariaController::class, 'show'])->name('maquinarias.show');

require __DIR__ . '/auth.php';
