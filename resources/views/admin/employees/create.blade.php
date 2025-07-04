@extends('layouts.private')
@section('content')
    <h1 style="font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px;">Alta de nuevo empleado</h1>

    @if ($errors->any())
        <div style="margin-bottom: 15px; max-width: 500px; margin-left: auto; margin-right: auto;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color:red;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="max-width: 500px; margin-left: auto; margin-right: auto;">
        <form action="{{ route('employees.store') }}" method="POST">
            @csrf

            <label style="display: block; margin-bottom: 5px;">Nombre completo:</label>
            <input type="text" name="name" value="{{ old('name') }}" style="margin-bottom: 15px; width: 100%;" required maxlength="100"><br>

            <label style="display: block; margin-bottom: 5px;">Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" style="margin-bottom: 15px; width: 100%;" required maxlength="150"><br>

            <label style="display: block; margin-bottom: 5px;">DNI:</label>
            <input type="text" name="dni" id="dni" value="{{ old('dni') }}" style="margin-bottom: 15px; width: 100%;" required maxlength="8" pattern="[0-9]{8}" placeholder="12345678"><br>

            <label style="display: block; margin-bottom: 5px;">Fecha de nacimiento:</label>
            <input type="text" name="fecha_nacimiento" id="fecha_nacimiento_flatpickr" value="{{ old('fecha_nacimiento') }}" style="margin-bottom: 5px; width: 100%;" required placeholder="Selecciona la fecha de nacimiento">
            <small style="color: #666; display: block; margin-bottom: 15px;">El empleado debe ser mayor de 18 años.</small><br>

            <label style="display: block; margin-bottom: 5px;">Teléfono:</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" style="margin-bottom: 15px; width: 100%;" required maxlength="20" placeholder="+54 9 11 1234-5678"><br>

            <label style="display: block; margin-bottom: 5px;">Contraseña:</label>
            <input type="password" name="password" id="password" style="margin-bottom: 15px; width: 100%;" required><br>

            <label style="display: block; margin-bottom: 5px;">Confirmar contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" style="margin-bottom: 20px; width: 100%;" required><br>

            <button type="submit" style="background-color: #f97316; color: white; font-weight: bold; padding: 10px 23px; border-radius: 3px; border: none; cursor: pointer; width:100%;">
                Crear Empleado
            </button>
        </form>

        <!-- Botón volver -->
        <div style="text-align: center; margin-top: 15px;">
            <a href="{{ route('employees.index') }}" style="color: #666; text-decoration: none;">
                ← Volver a la lista de empleados
            </a>
        </div>
    </div>

    {{-- CDN de Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    {{-- CSS simple para Flatpickr --}}
    <style>
        .flatpickr-input[readonly] { width: 100% !important; }
    </style>

    {{-- Script para DNI (igual que en register) --}}
    <script>
        document.getElementById('dni').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 8) {
                this.value = this.value.slice(0, 8);
            }
        });
    </script>

    {{-- Inicializar Flatpickr (igual que en register) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Calculamos la fecha máxima para tener 18 años
            let eighteenYearsAgo = new Date();
            eighteenYearsAgo.setFullYear(eighteenYearsAgo.getFullYear() - 18);

            // Asegurarse que flatpickr esté disponible globalmente desde app.js
            //if (typeof flatpickr !== 'undefined') {
            flatpickr("#fecha_nacimiento_flatpickr", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "j F, Y",
                maxDate: eighteenYearsAgo, // Usamos la fecha calculada
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
                },
                onReady: function(selectedDates, dateStr, instance) {
                    // 🔧 Forzar el ancho después de que Flatpickr se inicialice
                    if (instance.altInput) {
                        instance.altInput.style.width = '100%';
                        instance.altInput.style.boxSizing = 'border-box';
                    }
                }
            });
            //} else {
            // console.error('Flatpickr no está definido. Asegúrate de que app.js se cargue correctamente y defina window.flatpickr.');
            // }
        });
    </script>

    {{-- Validaciones del formulario --}}
    <script>
        const formElement = document.querySelector('form[action="{{ route('employees.store') }}"]');
        if (formElement) {
            formElement.addEventListener('submit', function(e) {
                // Validar DNI
                const dni = document.getElementById('dni').value;
                if (dni.length !== 8) {
                    e.preventDefault();
                    alert('El DNI debe tener exactamente 8 dígitos');
                    document.getElementById('dni').focus();
                    return;
                }

                // Validar contraseñas
                const passwordInput = document.getElementById('password');
                const confirmPasswordInput = document.getElementById('password_confirmation');

                if (passwordInput.value !== confirmPasswordInput.value) {
                    e.preventDefault();
                    alert('Las contraseñas no coinciden');
                    confirmPasswordInput.focus();
                    return;
                }

                if (passwordInput.value.length < 8) {
                    e.preventDefault();
                    alert('La contraseña debe tener al menos 8 caracteres');
                    passwordInput.focus();
                    return;
                }

                // Validar fecha de nacimiento (doble validación)
                const fechaNacimiento = document.querySelector('input[name="fecha_nacimiento"]');
                if (fechaNacimiento && fechaNacimiento.value) {
                    const fechaIngresada = new Date(fechaNacimiento.value);
                    const hoy = new Date();

                    if (fechaIngresada >= hoy) {
                        e.preventDefault();
                        alert('La fecha de nacimiento debe ser anterior a hoy');
                        fechaNacimiento.focus();
                        return;
                    }

                    // Verificar edad mínima (18 años)
                    const edad = hoy.getFullYear() - fechaIngresada.getFullYear();
                    const mesActual = hoy.getMonth();
                    const mesNacimiento = fechaIngresada.getMonth();

                    let edadFinal = edad;
                    if (mesNacimiento > mesActual || (mesNacimiento === mesActual && fechaIngresada.getDate() > hoy.getDate())) {
                        edadFinal--;
                    }

                    if (edadFinal < 18) {
                        e.preventDefault();
                        alert('El empleado debe ser mayor de 18 años');
                        fechaNacimiento.focus();
                        return;
                    }
                }
            });
        }
    </script>

@endsection
