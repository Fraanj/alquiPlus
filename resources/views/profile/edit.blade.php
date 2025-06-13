@extends('layouts.private')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mx-auto"> <!-- ← AGREGUÉ mx-auto -->
                <div class="max-w-xl mx-auto"> <!-- ← AGREGUÉ mx-auto -->
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div id="cambiar-clave" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mx-auto">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-password-form')
                </div>
            </div>


            <!--<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mx-auto"> --><!-- ← AGREGUÉ mx-auto -->
            <!--    <div class="max-w-xl mx-auto"> --><!-- ← AGREGUÉ mx-auto -->
            <!--       arroba include('profile.partials.delete-user-form')-->
            <!--   </div>-->
            <!-- </div>-->

            <div id="reservas" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mx-auto"> <!-- ← AGREGUÉ mx-auto -->
                <div class="max-w-3xl mx-auto"> <!-- Cambiado de max-w-xl a max-w-3xl para que no se desborde la tabla -->
                    @if(isset($reservas) && count($reservas))
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mx-auto mt-8">
                            <h2 class="text-lg font-semibold mb-4">Tus Reservas</h2>
                            <table class="min-w-full border border-gray-300">
                                <thead>
                                    <tr>
                                        <th class="border px-4 py-2">Máquina</th>
                                        <th class="border px-4 py-2">Fecha Inicio</th>
                                        <th class="border px-4 py-2">Fecha Fin</th>
                                        <th class="border px-4 py-2">Monto Total</th>
                                        <th class="border px-4 py-2">Rembolso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservas as $reserva)
                                        <tr>
                                            <td class="border px-4 py-2">
                                                {{ $reserva->maquinaria->nombre ?? 'Maquina Eliminada' }}
                                            </td>
                                            <td class="border px-4 py-2">{{ $reserva->fecha_inicio }}</td>
                                            <td class="border px-4 py-2">{{ $reserva->fecha_fin }}</td>
                                            <td class="border px-4 py-2">${{ $reserva->monto_total ?? '-' }}</td>
                                            <td class="border px-4 py-2">
                                                @if($reserva->activa())
                                                    <a href="{{ route('reservas.confirmarRembolso', $reserva->id) }}"
                                                    class="ml-2 inline-block px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs"
                                                    style="margin-left: 8px;">
                                                        Solicitar reembolso
                                                    </a>
                                                @else
                                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                                        Sin reembolso
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mx-auto mt-8 text-center text-gray-500">
                            Sin reservas registradas
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
