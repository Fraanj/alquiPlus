@extends('layouts.public')

@section('content')
<div style="max-width: 600px; margin: 40px auto; padding: 30px; background: #fff3cd; border: 1px solid #ffeeba; border-radius: 10px;">
    <h2 style="font-size: 20px; font-weight: bold; color: #856404;">¿Estás seguro de que deseas solicitar un reembolso?</h2>
    <p style="margin-top: 10px;"><strong>Máquina:</strong> {{ $reserva->maquinaria->nombre ?? 'Máquina no disponible' }}</p>
    <p><strong>Fecha de inicio:</strong> {{ $reserva->fecha_inicio }}</p>
    <p><strong>Fecha de fin:</strong> {{ $reserva->fecha_fin }}</p>
    <p><strong>Monto total:</strong> ${{ $reserva->monto_total }}</p>
    <p style="color: #856404; font-weight: bold;">Esta acción no se puede deshacer. Se te reembolsaran el {{ $reserva->getPoliticaReembolso()  }}% del monto total.</p>

    <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" style="margin-top: 20px;">
        @csrf
        @method('DELETE')
        
        <button type="submit" style="background-color: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 4px; font-weight: bold;">
            Confirmar reembolso
        </button>

        <a href="{{ route('profile.edit') }}" style="margin-left: 15px; text-decoration: none; color: #007bff;">
            Cancelar
        </a>
    </form>
</div>
@endsection