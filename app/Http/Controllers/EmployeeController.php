<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    /**
     * Mostrar lista de empleados
     */
    public function index(): View
    {
        $employees = User::employees()
            ->orderBy('is_active', 'desc') // Activos primero
            ->orderBy('name')
            ->get();

        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Mostrar formulario para crear empleado
     */
    public function create(): View
    {
        return view('admin.employees.create');
    }

    /**
     * Guardar nuevo empleado
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users'],
            'dni' => ['required', 'string', 'size:8', 'unique:users'],
            'fecha_nacimiento' => ['required', 'date', 'before:today'],
            'telefono' => ['required', 'string', 'max:20'],
        ]);

        $temporalPassword = Str::password(
            length: 12,
            letters: true,
            numbers: true,
            symbols: true,
            spaces: false
        );

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'dni' => $validated['dni'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'telefono' => $validated['telefono'],
            'password' => $validated['password'] = Hash::make($temporalPassword),
            'role' => 'employee',
            'is_active' => true,
        ]);

        \App\Services\MailService::enviarContraseñaMail($validated['email'], $temporalPassword);

        return redirect()->route('employees.index')
            ->with('success', 'Empleado creado exitosamente.');
    }

    /**
     * Mostrar formulario para editar empleado
     */
    public function edit(User $employee): View
    {
        // Verificar que sea empleado
        if (!$employee->isEmployee()) {
            abort(404);
        }

        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * Actualizar empleado
     */
    public function update(Request $request, User $employee): RedirectResponse
    {
        // Verificar que sea empleado
        if (!$employee->isEmployee()) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email,' . $employee->id],
            'dni' => ['required', 'string', 'size:8', 'unique:users,dni,' . $employee->id],
            'fecha_nacimiento' => ['required', 'date', 'before:today'],
            'telefono' => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'dni' => $validated['dni'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'telefono' => $validated['telefono'],
        ];

        // Solo actualizar password si se proporciona
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $employee->update($updateData);

        return redirect()->route('employees.index')
            ->with('success', 'Empleado actualizado exitosamente.');
    }

    /**
     * Desactivar empleado (baja lógica)
     */
    public function deactivate(User $employee): RedirectResponse
    {
        if (!$employee->isEmployee()) {
            abort(404);
        }

        $employee->deactivate();

        return redirect()->route('employees.index')
            ->with('success', 'Empleado desactivado exitosamente.');
    }

    /**
     * Activar empleado
     */
    public function activate(User $employee): RedirectResponse
    {
        if (!$employee->isEmployee()) {
            abort(404);
        }

        $employee->activate();

        return redirect()->route('employees.index')
            ->with('success', 'Empleado activado exitosamente.');
    }

    /**
     * Mostrar detalles del empleado
     */
    public function show(User $employee): View
    {
        if (!$employee->isEmployee()) {
            abort(404);
        }

        return view('admin.employees.show', compact('employee'));
    }
}
