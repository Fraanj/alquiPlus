<x-guest-layout>
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

        <!-- Edad -->
        <div class="mt-4">
            <x-input-label for="edad" :value="__('Edad')" />
            <x-text-input id="edad" class="block mt-1 w-full" type="number" name="edad" :value="old('edad')" required min="18" max="100" />
            <x-input-error :messages="$errors->get('edad')" class="mt-2" />
            <p class="text-sm text-gray-600 mt-1">Debe ser mayor o igual a 18 años</p>
        </div>

        <!-- Teléfono -->
        <div class="mt-4">
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <x-text-input id="telefono" class="block mt-1 w-full" type="tel" name="telefono" :value="old('telefono')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="text-sm text-gray-600 mt-1">Mínimo 8 caracteres</p>
        </div>

        <!-- Confirm Password -->
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

    <script>
        // Validación en tiempo real del DNI
        document.getElementById('dni').addEventListener('input', function(e) {
            // Solo permitir números
            this.value = this.value.replace(/[^0-9]/g, '');

            // Límite de 8 caracteres
            if (this.value.length > 8) {
                this.value = this.value.slice(0, 8);
            }
        });

        // Validación del formulario antes del envío
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
</x-guest-layout>
