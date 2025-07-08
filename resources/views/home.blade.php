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
                <option value="" disabled selected>Ordenar por precio</option>
                <option value="default">Sin ordenar</option>
                <option value="asc">Menor a mayor</option>
                <option value="desc">Mayor a menor</option>
            </select>
        </div>

        <div id="grid-catalogo-activos" class="grid-catalogo">
            <div id="mensaje-vacio"
                 style="display:none; text-align:center; color:#b91c1c; font-weight:bold; margin-top:2rem;">
                No se encontraron productos para la búsqueda realizada.
            </div>
            @foreach($maquinas as $maq)
                <div class="card"
                     data-nombre="{{ strtolower($maq->nombre) }}"
                     data-sucursal="{{ $maq->sucursal }}"
                     data-precio="{{ $maq->precio_por_dia }}"
                     data-descripcion="{{ strtolower($maq->descripcion) }}">
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
                                @else
                                    <span style="color:orange; font-weight:bold;">En mantenimiento</span>
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
                        @if(Auth::user()->isEmployee())
                            @if($maq->disponibilidad_id == 1)
                                <div>
                                    <a href="{{ route('maquinarias.maintenance', $maq->id) }}"
                                    class="btn btn-outline-warning btn-sm">
                                        🛠️ Mantenimiento
                                    </a>
                                </div>
                            @elseif($maq->disponibilidad_id == 3)
                                <div>
                                    <a href="{{ route('maquinarias.endMaintenance', $maq->id) }}"
                                    class="btn btn-outline-warning btn-sm">
                                        🛠️ Terminar Mantenimiento
                                    </a>
                                </div>
                            @endif
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
                <h2 class="titulo-eliminadas"
                    style="font-size:2rem; color:#d32f2f; font-weight:bold; letter-spacing:1px; margin-top:1.5rem; margin-bottom:1rem;">
                    Maquinarias eliminadas
                </h2>
                @if($maquinariasEliminadas->isEmpty())
                    <p>No se encuentran maquinas eliminadas</p>
                @else
                    <div id="grid-catalogo-eliminadas" class="grid-catalogo">
                        @foreach($maquinariasEliminadas as $maq)
                            {{-- Mostrar las máquinas eliminadas --}}
                            <div class="card card-eliminada"
                                 style="border: 2px dashed #b91c1c; border-radius: 10px; padding-bottom: 10px;">

                                <!-- Contenido grisado (solo esto tiene opacidad) -->
                                <div
                                    style="filter: grayscale(0.7) brightness(0.95); opacity: 0.6; cursor: not-allowed;">
                                    <img src="/images/{{ $maq->imagen }}" alt="{{ $maq->nombre }}" />
                                    <div class="card-content">
                                        <h2 style="font-weight: bold; color: #7a5c4b;">{{ $maq->nombre }}</h2>
                                        <p><strong>Código:</strong> {{ $maq->codigo }}</p>
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
                                </div>

                                <!-- Botón FUERA del área grisada -->
                                <div class="text-center mt-2">
                                    <button type="button"
                                            style="background-color: #28a745; color: white; font-weight: bold; padding: 6px 14px; border: none; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);"
                                            onclick="abrirModalRestaurar(`{{ route('maquinarias.restore', $maq->id) }}`, '{{ $maq->nombre }}')">
                                        ♻ Restaurar
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        @endauth

        <!-- Modal de confirmación reutilizable -->
        <div id="modal-restaurar"
             class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                <h2 class="text-lg font-bold text-gray-800 mb-4">¿Confirmar restauración?</h2>
                <p id="texto-maquina-restaurar" class="text-sm text-gray-600 mb-6"></p>

                <form id="form-restaurar" method="GET">
                    <div class="flex justify-end space-x-2">
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            Restaurar
                        </button>
                        <button type="button"
                                onclick="cerrarModalRestaurar()"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

<!-- mover esto al archivo JS -->
<script>
    function abrirModalRestaurar(url, nombre) {
        // Texto dentro del modal
        document.getElementById('texto-maquina-restaurar').innerText =
            `¿Estás seguro de que querés restaurar la máquina "${nombre}"?`;

        // Setea la acción del form con la URL generada
        document.getElementById('form-restaurar').action = url;

        // Muestra el modal
        document.getElementById('modal-restaurar').classList.remove('hidden');
    }

    function cerrarModalRestaurar() {
        document.getElementById('modal-restaurar').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('busqueda-nombre');
        const select = document.getElementById('filtro-sucursal');
        const orden = document.getElementById('ordenar-precio');
        const grid = document.getElementById('grid-catalogo-activos');
        const mensajeVacio = document.getElementById('mensaje-vacio');
        let cards = Array.from(grid.querySelectorAll('.card'));

        function filtrarYOrdenar() {
            const texto = input ? input.value.toLowerCase() : '';
            const sucursal = select ? select.value : '';
            const ordenValor = orden ? orden.value : 'default';

            // Filtrar
            cards.forEach(card => {
                const nombre = card.getAttribute('data-nombre') || '';
                const descripcion = card.getAttribute('data-descripcion') || '';
                const suc = card.getAttribute('data-sucursal') || '';
                const coincideNombre = nombre.includes(texto) || descripcion.includes(texto);
                const coincideSucursal = !sucursal || sucursal === 'Todas' || suc === sucursal;
                card.style.display = (coincideNombre && coincideSucursal) ? '' : 'none';
            });
            // Ordenar solo los visibles
            let visibles = cards.filter(card => card.style.display !== 'none');
            if (ordenValor === 'asc') {
                visibles.sort((a, b) => parseFloat(a.dataset.precio) - parseFloat(b.dataset.precio));
            } else if (ordenValor === 'desc') {
                visibles.sort((a, b) => parseFloat(b.dataset.precio) - parseFloat(a.dataset.precio));
            }
            visibles.forEach(card => grid.appendChild(card));

            // Mostrar/ocultar mensaje vacío
            if (mensajeVacio) {
                mensajeVacio.style.display = visibles.length === 0 ? 'block' : 'none';
            }
        }

        if (input) input.addEventListener('input', filtrarYOrdenar);
        if (select) select.addEventListener('change', filtrarYOrdenar);
        if (orden) orden.addEventListener('change', filtrarYOrdenar);
    });
</script>
