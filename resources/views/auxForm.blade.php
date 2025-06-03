<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<form method="POST" action="{{ route('reservas.create') }}" class="p-4 border rounded shadow-sm bg-light">
    @csrf

    <input type="hidden" name="maquina_id" value="{{ $maquina->id }}">
    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

    <div class="mb-3">
        <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="fecha_fin" class="form-label">Fecha de fin</label>
        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Alquilar</button>
</form>

<!-- <form method="POST" action="">
    @csrf
    <input type="hidden" name="maquina_id" value="{{ $maquina->id }}">
    <input type="date" name="fecha_inicio" required>
    <input type="date" name="fecha_fin" required>
    <button type="submit">Alquilar</button>
</form> -->