@extends('layouts.estadisticas', [
    'color' => 'green',
    'icon' => 'bar-chart-fill',
    'title' => 'Estadísticas de Reservas Totales',
    'route' => route('estadisticas.reservasTotales'),
    'totalLabel' => 'Total de reservas',
    'emptyMessage' => 'No se encontraron reservas en el rango de fechas seleccionado.',
    'chartTitle' => 'Reservas por día',
    'yAxisLabel' => 'Reservas Totales',
    'yAxisLabelDesc' => 'reserva(s)',
])