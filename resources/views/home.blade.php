@extends($layout) <!-- valor que devuelve le controlador  -->

@section('content')
    <div class="container py-4">
        <div class="grid-filtros">
            <input type="text" placeholder="Buscar por nombre..." />
            <select>
                <option value="">Filtrar por sucursal</option>
                <option value="La Plata">La Plata</option>
                <option value="Berazategui">Berazategui</option>
                <option value="Quilmes">Quilmes</option>
                <option value="Avellaneda">Avellaneda</option>
                <option value="Moreno">Moreno</option>
            </select>
            <select>
                <option value="">Ordenar por precio</option>
                <option value="asc">Menor a mayor</option>
                <option value="desc">Mayor a menor</option>
            </select>
        </div>

        <div class="grid-catalogo">
            @foreach($maquinas as $maq)
                <div class="card">
                    <a href="{{ route('maquinarias.show', ['id' => $maq->id]) }}"
                       style="text-decoration: none; color: inherit;">
                        <img src="/images/{{ $maq->imagen }}" alt="{{ $maq->nombre }}" />
                        <div class="card-content">
                            <h2>{{ $maq->nombre }}</h2>

                            {{-- Mostrar el Código solo para administradores autenticados --}}
                            @auth
                                @if(Auth::user()->isAdmin())
                                    <p><strong>Código:</strong> {{ $maq->codigo }}</p>
                                @endif
                            @endauth

                            {{-- Descripción eliminada --}}
                            {{-- <p><strong>Descripción:</strong> {{ $maq->descripcion }}</p> --}}

                            <p>Precio por día: <strong>${{ $maq->precio_por_dia }}</strong></p>
                            <p><strong>Estado:</strong>
                                @if($maq->disponibilidad_id == 1)
                                    <span style="color:green; font-weight:bold;">Disponible</span>
                                @elseif($maq->disponibilidad_id == 2)
                                    <span style="color:red; font-weight:bold;">No disponible</span>
                                @else
                                    <span style="color:red; font-weight:bold;">Fuera de servicio</span>
                                @endif
                            </p>
                        </div>
                    </a>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <div class="admin-actions" style="padding: 12px; border-top: 1px solid #eee;">
                                <a href="{{ route('maquinarias.edit', $maq->id) }}"
                                   class="btn btn-outline-primary btn-sm">
                                    ✏️ Editar
                                </a>
                                <a href="{{ route('maquinarias.destroy', $maq->id) }}"
                                   {{-- esta ruta la definís abajo --}}
                                   class="btn btn-outline-danger btn-sm">
                                    🗑️ Eliminar
                                </a>
                            </div>
                        @endif
                    @endauth
                </div>
                {{-- Botones dentro del card-body pero fuera del link --}}
            @endforeach
        </div>
    </div>
@endsection
