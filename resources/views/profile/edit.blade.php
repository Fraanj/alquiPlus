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

            <div id="reservas" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mx-auto">
                <div class="max-w-6xl mx-auto"> <!-- ✅ Cambiar de max-w-3xl a max-w-6xl -->
                    @if(isset($reservas) && count($reservas))
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mx-auto mt-8">
                            <h2 class="text-lg font-semibold mb-4">Tus Reservas</h2>
                            <div class="overflow-x-auto"> <!-- ✅ Agregar scroll horizontal para móviles -->
                                <table class="min-w-full border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="border px-6 py-3 text-left">Máquina</th> <!-- ✅ Más padding -->
                                            <th class="border px-6 py-3 text-center">Fecha Inicio</th>
                                            <th class="border px-6 py-3 text-center">Fecha Fin</th>
                                            <th class="border px-6 py-3 text-center">Monto Total</th>
                                            <th class="border px-6 py-3 text-center">Estado</th>
                                            <th class="border px-6 py-3 text-center">Rembolso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reservas as $reserva)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="border px-6 py-4 font-medium"> <!-- ✅ Más padding -->
                                                    {{ $reserva->maquinaria->nombre ?? 'Maquina Eliminada' }}
                                                </td>
                                                <td class="border px-6 py-4 text-center">{{ $reserva->fecha_inicio }}</td>
                                                <td class="border px-6 py-4 text-center">{{ $reserva->fecha_fin }}</td>
                                                <td class="border px-6 py-4 text-center font-semibold">${{ $reserva->monto_total ?? '-' }}</td>
                                                <td class="border px-6 py-4 text-center">{!! $reserva->getEstado() !!}</td>
                                                <td class="border px-6 py-4 text-center">
                                                    @if($reserva->activa())
                                                        <a href="{{ route('reservas.confirmarRembolso', $reserva->id) }}"
                                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-lg hover:from-red-600 hover:to-red-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg text-sm whitespace-nowrap">
                                                            <span class="inline-flex items-center">
                                                                💰 Solicitar reembolso
                                                            </span>
                                                        </a>
                                                    @else
                                                        <span class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-100 to-green-200 text-green-800 font-semibold rounded-lg text-sm whitespace-nowrap shadow-sm">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            Sin Reembolso
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
