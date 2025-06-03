@extends($layout) <!-- valor que devuelve le controlador  -->
@vite('resources/css/catalogo.css')

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
            <!-- Puedes generar estas cards dinámicamente más adelante -->
            @php
                $maquinarias = [
                  ['img' => 'tractorjohn.avif', 'nombre' => 'Tractor John Deere', 'precio' => 2500, 'sucursal' => 'La Plata'],
                  ['img' => 'retroex.jpeg', 'nombre' => 'Retroexcavadora CAT', 'precio' => 3800, 'sucursal' => 'Berazategui'],
                  ['img' => 'minibob.jpg', 'nombre' => 'Mini Cargadora Bobcat', 'precio' => 3100, 'sucursal' => 'Quilmes'],
                  ['img' => 'camion.jpeg', 'nombre' => 'Camión Volvo', 'precio' => 4200, 'sucursal' => 'Avellaneda'],
                  ['img' => 'komatsu.jpeg', 'nombre' => 'Excavadora Komatsu', 'precio' => 4600, 'sucursal' => 'Moreno'],
                  ['img' => 'grua.jpeg', 'nombre' => 'Grúa Torre', 'precio' => 5000, 'sucursal' => 'La Plata'],
                  ['img' => 'cargadora.jpeg', 'nombre' => 'Palas Cargadoras', 'precio' => 3300, 'sucursal' => 'Berazategui'],
                ];
            @endphp

            @foreach($maquinarias as $maq)
                <div class="card">
                    <img src="/images/{{ $maq['img'] }}" alt="{{ $maq['nombre'] }}" />
                    <div class="card-content">
                        <h2>{{ $maq['nombre'] }}</h2>
                        <p>Precio por día: <strong>${{ $maq['precio'] }}</strong></p>
                        <p>Sucursal: {{ $maq['sucursal'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
</div>
@endsection
