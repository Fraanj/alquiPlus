<x-guest-layout>
    {{-- Ya no necesitamos el CSS del CDN aquí, se importa en app.js --}}
    {{-- Ya no necesitamos el JS del CDN aquí, se importa en app.js --}}

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- DNI -->
        <div class="mt-4">
            <x-input-label for="dni" :value="__('DNI')" />
            <x-text-input id="dni" class="block mt-1 w-full" type="text" name="dni" :value="old('dni')" required maxlength="8" pattern="[0-9]{7,8}" />
            <x-input-error :messages="$errors->get('dni')" class="mt-2" />
            <p class="text-sm text-gray-600 mt-1">Ingrese su DNI sin puntos ni espacios (7 u 8 dígitos)</p>
        </div>

        <!-- Fecha de Nacimiento -->
        <div class="mt-4">
            <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
            <x-text-input id="fecha_nacimiento_flatpickr" class="block mt-1 w-full" type="text" name="fecha_nacimiento" :value="old('fecha_nacimiento')" required placeholder="Selecciona tu fecha de nacimiento" />
            <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
            <p class="text-sm text-gray-600 mt-1">Debes ser mayor de 18 años.</p>
        </div>

        <!-- Teléfono -->
        <div class="mt-4">
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <x-text-input id="telefono" class="block mt-1 w-full" type="tel" name="telefono" :value="old('telefono')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <!-- Password y Confirm Password (sin cambios) -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="text-sm text-gray-600 mt-1">Mínimo 8 caracteres</p>
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('¿Ya tienes cuenta?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>

    {{-- Script original del usuario para DNI (sin cambios) --}}
    <script>
        document.getElementById('dni').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 8) {
                this.value = this.value.slice(0, 8);
            }
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            const dni = document.getElementById('dni').value;
            if (dni.length < 7 || dni.length > 8) {
                e.preventDefault();
                alert('El DNI debe tener entre 7 y 8 dígitos');
                document.getElementById('dni').focus();
                return false;
            }
        });
    </script>

    {{-- Inicializar Flatpickr --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Calculamos la fecha máxima para tener 18 años
            let eighteenYearsAgo = new Date();
            eighteenYearsAgo.setFullYear(eighteenYearsAgo.getFullYear() - 18);

            // Asegurarse que flatpickr esté disponible globalmente desde app.js
            if (typeof flatpickr !== 'undefined') {
                flatpickr("#fecha_nacimiento_flatpickr", {
                    dateFormat: "Y-m-d",
                    altInput: true,
                    altFormat: "j F, Y",
                    maxDate: eighteenYearsAgo, // Usamos la fecha calculada
                    // minDate: "1900-01-01", // Descomentar si quieres una fecha mínima
                    allowInput: true, // Permite al usuario escribir la fecha directamente
                    locale: { // Opcional: para traducir Flatpickr al español
                        firstDayOfWeek: 1,
                        weekdays: {
                            shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                            longhand: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"]
                        },
                        months: {
                            shorthand: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                            longhand: [
                                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
                                "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                            ]
                        },
                        ordinal: () => { return "º"; }
                    }
                });
            } else {
                console.error('Flatpickr no está definido. Asegúrate de que app.js se cargue correctamente y defina window.flatpickr.');
            }
        });
    </script>
</x-guest-layout>
