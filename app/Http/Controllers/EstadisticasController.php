<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserva;
use Carbon\Carbon;
use App\Models\User;

class EstadisticasController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        if (!$usuario->isAdmin()) {
            abort(403, 'No autorizado');
        }

        return view('estadisticas.index');
    }

    public function montoFacturado(Request $request)
    {
        $usuario = Auth::user();
        if (!$usuario->isAdmin()) {
            abort(403, 'No autorizado');
        }

        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $hoy = Carbon::today()->format('Y-m-d');

        if ($fechaInicio && $fechaFin) {
            if ($fechaInicio > $fechaFin) {
                return redirect()->back()->with('error', 'La fecha de inicio no puede ser mayor que la fecha de fin.');
            }

            if ($fechaInicio > $hoy || $fechaFin > $hoy) {
                return redirect()->back()->with('error', 'Las fechas no pueden estar en el futuro.');
            }

            // Consultar reservas en el rango
            $reservas = Reserva::whereBetween('fecha_reserva', [$fechaInicio, $fechaFin])->get();

            if ($reservas->isEmpty()) {
                return view('estadisticas.montoFacturado', [
                    'total' => 0,
                    'dataPoints' => [],
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin,
                    'hoy' => $hoy
                ]);
            }

            $total = $reservas->sum('monto_total');

            // Agrupar por día
            $dataPoints = $reservas->groupBy(function ($res) {
                return Carbon::parse($res->fecha_reserva)->format('Y-m-d');
            })->map(function ($items) {
                return $items->sum('monto_total');
            });

            return view('estadisticas.montoFacturado', [
                'total' => $total,
                'dataPoints' => $dataPoints,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'hoy' => $hoy
            ]);
        }

        // Primer carga sin fechas
        return view('estadisticas.montoFacturado', ['hoy' => $hoy]);
    }

   public function reservasTotales(Request $request)
{
    $usuario = Auth::user();
    if (!$usuario->isAdmin()) {
        abort(403, 'No autorizado');
    }

    $fechaInicio = $request->input('fecha_inicio');
    $fechaFin = $request->input('fecha_fin');
    $hoy = \Carbon\Carbon::today()->format('Y-m-d');

    if ($fechaInicio && $fechaFin) {
        if ($fechaInicio > $fechaFin) {
            return redirect()->back()->with('error', 'La fecha de inicio no puede ser mayor que la fecha de fin.');
        }

        if ($fechaInicio > $hoy || $fechaFin > $hoy) {
            return redirect()->back()->with('error', 'Las fechas no pueden estar en el futuro.');
        }

        $reservas = Reserva::whereBetween('fecha_reserva', [$fechaInicio, $fechaFin])->get();

        if ($reservas->isEmpty()) {
            return view('estadisticas.reservasTotales', [
                'total' => 0,
                'dataPoints' => [],
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'hoy' => $hoy
            ]);
        }

        $total = $reservas->count();

        // Agrupar por día (cantidad de reservas)
        $dataPoints = $reservas->groupBy(function ($res) {
            return \Carbon\Carbon::parse($res->fecha_reserva)->format('Y-m-d');
        })->map(function ($items) {
            return $items->count();
        });

        return view('estadisticas.reservasTotales', [
            'total' => $total,
            'dataPoints' => $dataPoints,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'hoy' => $hoy
        ]);
    }

    return view('estadisticas.reservasTotales', ['hoy' => $hoy]);
}


public function nuevosClientes(Request $request)
{
    $usuario = Auth::user();
    if (!$usuario->isAdmin()) {
        abort(403, 'No autorizado');
    }

    if ($request->has(['fecha_inicio', 'fecha_fin'])) {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $query = User::where('role', 'user')
                     ->whereDate('created_at', '>=', $fechaInicio)
                     ->whereDate('created_at', '<=', $fechaFin);

        $total = $query->count();

        $data = $query->selectRaw('DATE(created_at) as fecha, COUNT(*) as cantidad')
                      ->groupBy('fecha')
                      ->orderBy('fecha')
                      ->get();

        $dataPoints = [];
        foreach ($data as $d) {
            $dataPoints[$d->fecha] = $d->cantidad;
        }
    } else {
        $fechaInicio = null;
        $fechaFin = null;
        $total = null;
        $dataPoints = [];
    }

    $hoy = now()->toDateString();

    return view('estadisticas.nuevosClientes', compact('total', 'dataPoints', 'fechaInicio', 'fechaFin', 'hoy'));
}

}
