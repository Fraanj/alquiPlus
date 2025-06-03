@extends('layouts.public')
@section('content')
  <h1 style="font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px;">Carga de maquinaria</h1>

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
        <form action="/maquinarias" method="POST" enctype="multipart/form-data">
            @csrf

            <label style="display: block; margin-bottom: 5px;">Nombre:</label>
            <input type="text" name="nombre" required style="margin-bottom: 15px; width: 100%;"><br>

            <label style="display: block; margin-bottom: 5px;">Descripción:</label>
            <textarea name="descripcion" style="margin-bottom: 15px; width: 100%;"></textarea><br>

            <label style="display: block; margin-bottom: 5px;">Tipo de Maquinaria:</label>
            <select name="tipo_id" required style="margin-bottom: 15px; width: 100%;">
            <option value=""> Seleccione un tipo </option>
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
            @endforeach
            </select>

            <label style="display: block; margin-bottom: 5px;">Precio por día:</label>
            <input type="number" step="0.01" name="precio_por_dia" requiered min="0" required style="margin-bottom: 15px; width: 100%;"><br>

            <label style="display: block; margin-bottom: 5px;">Imagen:</label>
            <input type="file" name="imagen" id="imagen" accept=".jpg,.jpeg" style="margin-bottom: 5px; width: 100%;">
            <small id="errorImagen" style="color: red; display: none; margin-bottom: 15px;"></small>


            <label style="display: block; margin-bottom: 5px;">Política de reembolso:</label>
            <select name="politica_reembolso" required style="margin-bottom: 15px; width: 100%;">
                <option value="0">0%</option>
                <option value="20">20%</option>
                <option value="100">100%</option>
            </select><br>

            <label style="display: block; margin-bottom: 5px;">Disclaimer (Opcional):</label>
            <input type="text" name="disclaimer" style="margin-bottom: 15px; width: 100%;"><br>

            <label style="display: block; margin-bottom: 5px;">Año de producción:</label>
            <input type="number" name="anio_produccion" required style="margin-bottom: 20px; width: 100%;"><br>

            <button type="submit" style="background-color: #f97316; color: white; font-weight: bold; padding: 10px 23px; border-radius: 3px; border: none; cursor: pointer; width:100%;">
                Guardar Maquinaria
            </button>
        </form>
    </div>

    <script>
    const fileInput = document.querySelector('input[name="imagen"]');
    const preview = document.getElementById('preview');

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (!file) {
            if(preview) {
                preview.src = "#";
                preview.style.display = 'none';
            }
            return;
        }

        if (file.type !== 'image/jpeg') {
            alert('Sólo se permiten imágenes JPG.');
            fileInput.value = '';
            if(preview) {
                preview.src = "#";
                preview.style.display = 'none';
            }
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            if(preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        };
        reader.readAsDataURL(file);
    });
</script>

<script>
  document.querySelector('form').addEventListener('submit', function(e) {
    const precioInput = this.querySelector('input[name="precio_por_dia"]');
    const precio = parseFloat(precioInput.value);

    if (precio < 0) {
      e.preventDefault(); // detiene el envío del formulario
      alert('El precio no puede ser negativo');
      precioInput.focus();
    }
  });
</script>

@endsection
