<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Información del Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Actualiza la información de tu perfil y correo electrónico.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Tu correo electrónico no está verificado.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click aquí para reenviar el correo de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="dni" :value="__('DNI')" />
            <x-text-input id="dni" name="dni" type="text" class="mt-1 block w-full" :value="old('dni', $user->dni)" required maxlength="8" pattern="[0-9]{7,8}" />
            <x-input-error class="mt-2" :messages="$errors->get('dni')" />
            <p class="text-sm text-gray-600 mt-1">DNI sin puntos ni espacios (7 u 8 dígitos)</p>
        </div>

        <div>
            <x-input-label for="fecha_nacimiento_profile_flatpickr" :value="__('Fecha de Nacimiento')" />
            {{-- Cambiado type a text y el ID --}}
            <x-text-input id="fecha_nacimiento_profile_flatpickr" name="fecha_nacimiento" type="text" class="mt-1 block w-full" :value="old('fecha_nacimiento', $user->fecha_nacimiento ? $user->fecha_nacimiento->format('Y-m-d') : '')" required placeholder="Selecciona tu fecha de nacimiento"/>
            <x-input-error class="mt-2" :messages="$errors->get('fecha_nacimiento')" />
            <p class="text-sm text-gray-600 mt-1">Debes ser mayor de 18 años.</p>
        </div>

        <div>
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <x-text-input id="telefono" name="telefono" type="tel" class="mt-1 block w-full" :value="old('telefono', $user->telefono)" />
            <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
        </div>

        

    <div>
        <x-input-label for="password" :value="__('Verificar Contraseña')" />
        <x-text-input id="password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
        <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
        <p class="text-sm text-gray-600 mt-1">Introduce tu contraseña para confirmar los cambios.</p>
    </div>

    <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>

    {{-- Script original del usuario para DNI --}}
    <script>
        // Validación en tiempo real del DNI
        // Se asume que id="dni" es el correcto para este campo en este formulario.
        // Si este es un partial que se carga en una página con otro input con id="dni",
        // considera darle un ID único como 'dni_profile' para evitar conflictos.
        // Por ahora, lo dejamos como 'dni' según tu código original.
        const dniInputProfile = document.getElementById('dni');
        if (dniInputProfile) {
            dniInputProfile.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 8) {
                    this.value = this.value.slice(0, 8);
                }
            });
        }

        // Validación del formulario antes del envío
        const profileUpdateForm = document.querySelector('form[action*="profile.update"]');
        if (profileUpdateForm) {
            profileUpdateForm.addEventListener('submit', function(e) {
                const dniValue = dniInputProfile ? dniInputProfile.value : ''; // Usar la variable ya definida
                if (dniValue.length < 7 || dniValue.length > 8) {
                    e.preventDefault();
                    alert('El DNI debe tener entre 7 y 8 dígitos');
                    if (dniInputProfile) dniInputProfile.focus();
                    return false;
                }
            });
        }
    </script>

    {{-- Inicializar Flatpickr para el campo de fecha de nacimiento del perfil --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Calculamos la fecha máxima para tener 18 años
            let eighteenYearsAgo = new Date();
            eighteenYearsAgo.setFullYear(eighteenYearsAgo.getFullYear() - 18);

            // Asegurarse que flatpickr esté disponible globalmente desde app.js
            if (typeof flatpickr !== 'undefined') {
                flatpickr("#fecha_nacimiento_profile_flatpickr", { // ID actualizado
                    dateFormat: "Y-m-d",
                    altInput: true,
                    altFormat: "j F, Y",
                    defaultDate: "{{ $user->fecha_nacimiento ? $user->fecha_nacimiento->format('Y-m-d') : '' }}", // Para pre-llenar con el valor actual
                    maxDate: eighteenYearsAgo,
                    allowInput: true,
                    locale: {
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
                console.error('Flatpickr no está definido en profile form. Asegúrate de que app.js se cargue correctamente y defina window.flatpickr.');
            }
        });
    </script>
</section>
