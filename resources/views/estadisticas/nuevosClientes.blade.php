@extends('layouts.estadisticas', [
    'color' => 'purple',
    'icon' => 'people-fill',
    'title' => 'Estadísticas de Nuevos Clientes',
    'route' => route('estadisticas.nuevos-clientes'),
    'totalLabel' => 'Total nuevos clientes',
    'emptyMessage' => 'No se encontraron nuevos clientes en el rango de fechas seleccionado.',
    'chartTitle' => 'Nuevos clientes por día',
    'yAxisLabel' => 'Cantidad de clientes',
    'yAxisLabelDesc' => 'cliente(s)',
])