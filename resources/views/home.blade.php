@extends($layout) <!-- valor que devuelve le controlador  -->

@section('content')
    <div class="container py-4">
        <div class="grid-filtros">
            <input type="text" id="busqueda-nombre" placeholder="Buscar por nombre..." />
            <select id="filtro-sucursal">
                <option value="" disabled selected>Filtrar por sucursal</option>
                <option value="Todas">Todas las sucursales</option>
                <option value="La Plata">La Plata</option>
                <option value="Berisso">Berisso</option>
                <option value="Ensenada">Ensenada</option>
            </select>
            <select id="ordenar-precio">
                <option value="" disabled selected>Ordenar por precio </option>
                <option value="default">Sin ordenar</option>
                <option value="asc">Menor a mayor</option>
                <option value="desc">Mayor a menor</option>
            </select>
        </div>

        <div class="grid-catalogo">
            @foreach($maquinas as $maq)
                <div class="card" data-nombre="{{ strtolower($maq->nombre) }}" data-sucursal="{{ $maq->sucursal }}" data-precio="{{ $maq->precio_por_dia }}">
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
                            <p><strong>Sucursal:</strong> {{ $maq->sucursal }}</p>
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

        @auth
            @if(Auth::user()->isAdmin())
                <!-- maquinarias eliminadas -->
                <br>
                <h2 class="titulo-eliminadas" style="font-size:2rem; color:#d32f2f; font-weight:bold; letter-spacing:1px; margin-top:1.5rem; margin-bottom:1rem;">
                    Maquinarias eliminadas
                </h2>
                <div class="grid-catalogo">
                    @foreach($maquinariasEliminadas as $maq)
                        {{-- Mostrar las máquinas eliminadas --}}
                        <div class="card card-eliminada"
                            style="filter: grayscale(0.7) brightness(0.95); opacity: 0.6; border: 2px dashed #b91c1c;">
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
                                    <a href="{{ route('maquinarias.restore', $maq->id) }}"
                                        class="btn btn-outline-danger btn-sm">
                                        Restaurar
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>
            @endif
        @endauth
@endsection

<!-- mover esto al archivo JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('busqueda-nombre');
    const select = document.getElementById('filtro-sucursal');
    const orden = document.getElementById('ordenar-precio');
    const grid = document.querySelector('.grid-catalogo');
    let cards = Array.from(document.querySelectorAll('.card'));

    function filtrarYOrdenar() {
        const texto = input ? input.value.toLowerCase() : '';
        const sucursal = select ? select.value : '';
        const ordenValor = orden ? orden.value : 'default';

        // Filtrar
        cards.forEach(card => {
            const nombre = card.getAttribute('data-nombre') || '';
            const suc = card.getAttribute('data-sucursal') || '';
            const coincideNombre = nombre.includes(texto);
            const coincideSucursal = !sucursal || sucursal === "Todas" || suc === sucursal;
            card.style.display = (coincideNombre && coincideSucursal) ? '' : 'none';
        });

        // Ordenar solo los visibles
        let visibles = cards.filter(card => card.style.display !== 'none');
        if (ordenValor === 'asc') {
            visibles.sort((a, b) => parseFloat(a.dataset.precio) - parseFloat(b.dataset.precio));
        } else if (ordenValor === 'desc') {
            visibles.sort((a, b) => parseFloat(b.dataset.precio) - parseFloat(a.dataset.precio));
        }
        // Reordenar en el DOM solo los visibles
        visibles.forEach(card => grid.appendChild(card));
    }

    if(input) input.addEventListener('input', filtrarYOrdenar);
    if(select) select.addEventListener('change', filtrarYOrdenar);
    if(orden) orden.addEventListener('change', filtrarYOrdenar);
});
</script>