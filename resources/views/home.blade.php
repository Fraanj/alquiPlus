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
                <a href="{{ route('maquinarias.show', ['id' => $maq->id]) }}" class="card" style="text-decoration: none; color: inherit;">
                    <img src="/images/{{ $maq->imagen }}" alt="{{ $maq->nombre }}" />
                    <div class="card-content">
                        <h2>{{ $maq->nombre }}</h2>
                        <p>Precio por día: <strong>${{ $maq->precio_por_dia }}</strong></p>
                        <p>{{ $maq->descripcion }}</p>
                    </div>
                </a>
            @endforeach
        </div>
</div>
@endsection
