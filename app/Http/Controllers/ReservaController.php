<?php

namespace App\Http\Controllers;

use App\Models\Maquinaria;
use Illuminate\Http\Request;
use App\Models\Reserva;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use carbon\Carbon;
class ReservaController extends Controller
{
    public function form()
    {
        // Aquí podrías obtener las reservas del usuario autenticado
        // Por ejemplo, usando Auth::user()->reservas si tienes una relación definida
        $maquina = Maquinaria::find(1);
        return view('auxForm', [
            'maquina' => $maquina,
        ]);
    }

    private function calculateMonto($maquina_id, $fecha_inicio, $fecha_fin) {
            $maquina = Maquinaria::find($maquina_id);
            $inicio = \Carbon\Carbon::parse($fecha_inicio);
            $fin = \Carbon\Carbon::parse($fecha_fin);
            $dias = $fin->diffInDays($inicio) + 1;
            return $maquina->precio * $dias;
        }
    public function create(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'maquina_id' => 'required|exists:maquinarias,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // Crear objeto reserva sin guardar en DB
        $reserva = new Reserva();
        $reserva->maquina_id = $validated['maquina_id'];
        $reserva->user_id = auth()->id();
        $reserva->fecha_inicio = $validated['fecha_inicio'];
        $reserva->fecha_fin = $validated['fecha_fin'];
        $reserva->monto_total= $this->calculateMonto($reserva->maquina_id,$reserva->fecha_inicio,$reserva->fecha_fin);
        $reserva->fecha_reserva = now();

        // Guardar temporalmente en sesión
        session(['reserva_temporal' => $reserva]);

        return redirect()->route('reservas.pago');
    }

    public function pago(Request $request)
    {
        if ($request->method() === 'POST') {
            // Aquí procesarías el pago
            // Por ejemplo, podrías llamar a un servicio de pago externo

            // Si el pago es exitoso, guardar la reserva en la base de datos
            $reserva = session('reserva_temporal');
            $reserva->save();

            // Limpiar la sesión
            session()->forget('reserva_temporal');

            return redirect()->route('home')->with('success', 'Reserva realizada con éxito.');
        }
        else {
            // Mostrar el formulario de pago
            $reserva = session('reserva_temporal');
            if (!$reserva) {
                return redirect()->route('home')->with('error', 'No hay reserva temporal.');
            }

            return view('pago', [
                'reserva' => $reserva,
            ]);
        }
    }
}