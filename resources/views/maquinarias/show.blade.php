@extends('layouts.public')

@section('content')
<style>
  .maquinaria-container {
    max-width: 900px;
    margin: 40px auto;
    box-shadow: 0 3px 12px rgb(0 0 0 / 0.15);
    border-radius: 12px;
    display: flex;
    gap: 24px;
    padding: 40px 24px 56px 24px; /* más padding abajo */
    background: #fff;
    min-height: 420px; /* más alto para que no quede tan cuadrado */
  }

  .maquinaria-imagen {              /*para editar la imagen*/
  flex: 1 1 40%;
  max-height: 300px;
  max-width: 55%; 
  border-radius: 12px;
  object-fit: cover;
  box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
}


  .maquinaria-info {
    flex: 1 1 60%;
    display: flex;
    flex-direction: column;
  }

  .maquinaria-nombre {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 8px;
    color: #333;
  }

  .precio {
    font-size: 1.5rem;
    color: #198754;
    font-weight: 600;
    margin-bottom: 12px;
  }

  .badges {
    margin-bottom: 12px;
  }

  .badge {
    display: inline-block;
    background: #0dcaf0;
    color: #000;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-right: 10px;
    user-select: none;
  }

  .badge.disponible {
    background: #198754;
    color: #fff;
  }

  .badge.no-disponible {
    background: #dc3545;
    color: #fff;
  }

  .descripcion {
    font-size: 1.1rem;
    margin-bottom: 12px;
    line-height: 1.4;
    color: #444;
  }

  .disclaimer {
    background: #fff3cd;
    padding: 12px;
    border-radius: 8px;
    font-size: 0.9rem;
    color: #664d03;
    margin-bottom: 20px;
    border: 1px solid #ffeeba;
  }

  .btn-alquilar {
    background-color: #f97316;
    color: white;
    font-weight: bold;
    padding: 10px 23px;
    border-radius: 3px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: fit-content;
    align-self: flex-start;
    font-size: 1.1rem;
  }

  .btn-alquilar:hover:not(:disabled) {
    background-color: #d6640d;
  }

  .btn-alquilar:disabled {
    background-color: #ccc;
    cursor: not-allowed;
  }

  .extras {
    margin-top: 20px;
    font-size: 0.95rem;
    color: #444;
  }

  .politica {
    margin-top: 8px;
    font-size: 0.9rem;
    color: #6c757d;
  }

  .badge.tipo {
    background-color: #e0e0e0;
    color: #000;
  }

  @media (max-width: 600px) {
    .maquinaria-container {
      flex-direction: column;
      max-width: 95%;
      padding: 16px;
    }

    .maquinaria-imagen {
      max-height: 250px;
      width: 100%;
      margin-bottom: 20px;
      max-width: 350px;
    }

    .maquinaria-info {
      flex: none;
    }

    .btn-alquilar {
      width: 100%;
      text-align: center;
    }
  }
</style>

<div class="maquinaria-container">
  @if ($maquinaria->imagen)
  <img src="{{ asset(str_replace('public/', '', $maquinaria->imagen)) }}" alt="{{ $maquinaria->nombre }}" class="maquinaria-imagen">

@endif

  <div class="maquinaria-info">
    <h1 class="maquinaria-nombre">{{ $maquinaria->nombre }}</h1>
    <div class="precio">${{ number_format($maquinaria->precio_por_dia, 2) }} / día</div>

    <div class="badges" style="display: flex; gap: 12px; align-items: center;">
  <span class="badge tipo">Tipo: {{ $maquinaria->tipo->nombre ?? 'Sin especificar' }}</span>
  <span class="badge">Año: {{ $maquinaria->anio_produccion }}</span>

  @if($maquinaria->disponibilidad_id == 1)
    <span class="badge disponible">Disponible</span>
  @elseif($maquinaria->disponibilidad_id == 2)
    <span class="badge no-disponible">No disponible</span>
  @else
    <span class="badge no-disponible">Fuera de servicio</span>
  @endif
</div>



    <p class="descripcion">{{ $maquinaria->descripcion }}</p>

    @if ($maquinaria->disclaimer)
      <div class="disclaimer">{{ $maquinaria->disclaimer }}</div>
    @endif

    <button type="submit" class="btn-alquilar"
        @if($maquinaria->disponibilidad_id != 1) disabled @endif
        onmouseover="if(!this.disabled) this.style.backgroundColor='#d6640d'" 
        onmouseout="if(!this.disabled) this.style.backgroundColor='#f97316'">
        Reservar
    </button>


    <div class="extras">
      <div class="politica">
        Política de cancelación: 
        @if($maquinaria->politica_reembolso == '100')
          Reembolso completo
        @elseif($maquinaria->politica_reembolso == '20')
          Reembolso del 20%
        @else
          Sin reembolso
        @endif
      </div>
    </div>
  </div>
</div>


@endsection
