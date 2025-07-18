@extends('layouts.estadisticas', [
    'color' => 'blue',
    'icon' => 'currency-dollar',
    'title' => 'Estadísticas de Montos Facturados',
    'route' => route('estadisticas.montoFacturado'),
    'totalLabel' => 'Total facturado',
    'emptyMessage' => 'No hay montos facturados en el rango de fechas seleccionado.',
    'chartTitle' => 'Monto facturado por día',
    'yAxisLabel' => 'Monto Total ($)',
    'yAxisLabelDesc' => 'pesos',
])