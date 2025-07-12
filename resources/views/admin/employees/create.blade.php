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
        <!-- ✅ Información sobre la contraseña -->
        <div style="background-color: #e0f2fe; border-left: 4px solid #0288d1; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                <span style="font-size: 18px; margin-right: 8px;">🔐</span>
                <strong style="color: #0277bd;">Contraseña automática</strong>
            </div>
            <p style="margin: 0; color: #01579b; font-size: 14px; line-height: 1.4;">
                Se generará automáticamente una contraseña segura y será enviada al email del empleado.
            </p>
        </div>

        <form action="{{ route('employees.store') }}" method="POST">
            @csrf

            <label style="display: block; margin-bottom: 5px;">Nombre completo:</label>
            <input type="text" name="name" value="{{ old('name') }}" style="margin-bottom: 15px; width: 100%;" required maxlength="100"><br>

            <label style="display: block; margin-bottom: 5px;">Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" style="margin-bottom: 15px; width: 100%;" required maxlength="150"><br>

            <label style="display: block; margin-bottom: 5px;">DNI:</label>
            <input type="text" name="dni" id="dni" value="{{ old('dni') }}" style="margin-bottom: 15px; width: 100%;" required maxlength="8" pattern="[0-9]{8}" placeholder="12345678"><br>

            <label style="display: block; margin-bottom: 5px;">Fecha de nacimiento:</label>
            <input type="text" name="fecha_nacimiento" id="fecha_nacimiento_flatpickr" value="{{ old('fecha_nacimiento') }}" style="margin-bottom: 5px; width: 100%;" required placeholder="Selecciona la fecha de nacimiento" autocomplete="off">
            <small style="color: #666; display: block; margin-bottom: 15px;">El empleado debe ser mayor de 18 años.</small><br>

            <label style="display: block; margin-bottom: 5px;">Teléfono:</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" style="margin-bottom: 15px; width: 100%;" required maxlength="20" placeholder="+54 9 11 1234-5678"><br>

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

    <!-- ✅ Flatpickr CSS y JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ✅ Configurar Flatpickr para fecha de nacimiento
            flatpickr("#fecha_nacimiento_flatpickr", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                maxDate: new Date(new Date().setFullYear(new Date().getFullYear() - 18)), // Máximo 18 años atrás
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
                    ordinal: () => "º"
                },
                allowInput: true,
                clickOpens: true,
                onReady: function(selectedDates, dateStr, instance) {
                    if (instance.altInput) {
                        instance.altInput.style.width = '100%';
                        instance.altInput.style.boxSizing = 'border-box';
                    }
                },
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        const selectedDate = selectedDates[0];
                        const today = new Date();
                        const age = today.getFullYear() - selectedDate.getFullYear();
                        const monthDiff = today.getMonth() - selectedDate.getMonth();
                        
                        // Verificar si es mayor de 18 años
                        if (age < 18 || (age === 18 && monthDiff < 0) || 
                            (age === 18 && monthDiff === 0 && today.getDate() < selectedDate.getDate())) {
                            alert('El empleado debe ser mayor de 18 años.');
                            instance.clear();
                        }
                    }
                }
            });

            // ✅ Validación del DNI (solo números)
            document.getElementById('dni').addEventListener('input', function (e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    </script>
@endsection