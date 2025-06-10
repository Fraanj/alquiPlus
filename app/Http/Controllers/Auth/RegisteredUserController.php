<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon; // Importar Carbon

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register'); // Asegúrate que la vista 'auth.register' se actualice para pedir fecha_nacimiento
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:150', 'unique:'.User::class],
            'dni' => ['required', 'string', 'regex:/^[0-9]{7,8}$/', 'unique:'.User::class],
            // 'edad' => ['required', 'integer', 'min:18', 'max:100'], // Validación original eliminada
            'fecha_nacimiento' => [
                'required',
                'date',
                'before_or_equal:' . Carbon::now()->subYears(18)->format('Y-m-d'), // Debe tener al menos 18 años
                'after_or_equal:' . Carbon::now()->subYears(100)->format('Y-m-d') // No más de 100 años
            ],
            'telefono' => ['nullable','string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 100 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.regex' => 'El DNI debe contener entre 7 y 8 dígitos.',
            'dni.unique' => 'Este DNI ya está registrado.',
            // Mensajes para 'edad' eliminados
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento no es una fecha válida.',
            'fecha_nacimiento.before_or_equal' => 'Debes tener al menos 18 años para registrarte.',
            'fecha_nacimiento.after_or_equal' => 'La fecha de nacimiento indica una edad mayor a 100 años.',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'dni' => $request->dni,
            // 'edad' => $request->edad, // Campo original eliminado
            'fecha_nacimiento' => $request->fecha_nacimiento, // Nuevo campo
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
            'role' => 'user', // Por defecto todos se registran como 'user'
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
