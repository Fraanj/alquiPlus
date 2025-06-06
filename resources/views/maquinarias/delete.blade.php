@extends('layouts.public')

@section('content')
<div style="max-width: 600px; margin: 40px auto; padding: 30px; background: #fff3cd; border: 1px solid #ffeeba; border-radius: 10px;">
    <h2 style="font-size: 20px; font-weight: bold; color: #856404;">¿Estás seguro de que deseas eliminar la maquinaria?</h2>
    <p style="margin-top: 10px;"><strong>Nombre:</strong> {{ $maquinaria->nombre }}</p>
    <p><strong>Tipo:</strong> {{ $maquinaria->tipo->nombre ?? 'Sin tipo' }}</p>
    <p style="color: #dc3545; font-weight: bold;">Esta acción no se puede deshacer.</p>

    <form action="{{ route('maquinarias.destroy', $maquinaria->id) }}" method="POST" style="margin-top: 20px;">
        @csrf
        @method('DELETE')

        <button type="submit" style="background-color: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 4px; font-weight: bold;">
            Confirmar eliminación
        </button>

        <a href="{{ route('home') }}" style="margin-left: 15px; text-decoration: none; color: #007bff;">
            Cancelar
        </a>
    </form>
</div>
@endsection