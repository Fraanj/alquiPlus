<?php

namespace App\Http\Controllers;

use App\Models\Maquinaria;
use App\Models\Reserva;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Carbon\Carbon;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class ReservaController extends Controller
{
    public function form()
    {
        $maquina = Maquinaria::find(1);
        return view('auxForm', ['maquina' => $maquina]);
    }

    private function calculateMonto($maquina_id, $fecha_inicio, $fecha_fin)
    {
        $maquina = Maquinaria::find($maquina_id);
        $inicio = Carbon::parse($fecha_inicio);
        $fin = Carbon::parse($fecha_fin);
        $dias = $inicio->diffInDays($fin) + 1;
        return $maquina->precio_por_dia * $dias;
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'maquina_id' => 'required|exists:maquinarias,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $reserva = new Reserva();
        $reserva->maquina_id = $validated['maquina_id'];
        $reserva->user_id = auth()->id();
        $reserva->fecha_inicio = $validated['fecha_inicio'];
        $reserva->fecha_fin = $validated['fecha_fin'];
        $reserva->monto_total = $this->calculateMonto(
            $reserva->maquina_id,
            $reserva->fecha_inicio,
            $reserva->fecha_fin
        );
        $reserva->fecha_reserva = now();

        session(['reserva_temporal' => $reserva]);

        return redirect()->route('reservas.pago');
    }

public function pago(Request $request)
{
    $reserva = session('reserva_temporal');

    if (!$reserva) {
        return redirect()->route('home')->with('error', 'No hay reserva temporal.');
    }

    // 🔐 Clave pública y token (ya estén en POST o GET)
    $publicKey = config('services.mercadopago.key');
    MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));

    // 🛒 Crear la preferencia
    $client = new PreferenceClient();
    $maquina = Maquinaria::find($reserva->maquina_id);
    $preference = $client->create([
        "items" => [[
            "title" => $maquina->nombre,
            "quantity" => 1,
            "unit_price" => $reserva->monto_total
        ]],
        "statement_descriptor" => "MANNY Maquinarias",
        "external_reference" => "reserva_" . uniqid(),

        /* "back_urls" => [
            "success" => url('home') , //AGREGAR EL RETORNO AYUDAAAAAAA <<<<<<<<<<<<<----------------------------
            "failure" => url('home') ,
            "pending" => url('home') ,
        ],
        "auto_return" => "approved" */
    ]);

    $reserva->save();
    session()->forget('reserva_temporal');
    // También podrías guardar el preference ID como referencia si lo querés asociar con la reserva.

    return view('pagos.create', compact('publicKey', 'preference'));
}
    /*
    public function pago(Request $request)
    {
    if ($request->isMethod('post')) {
        $reserva = session('reserva_temporal');
        if ($reserva) {
            $reserva->save();
            session()->forget('reserva_temporal');

            // Preparar MercadoPago
            $publicKey = config('services.mercadopago.key');
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));

            $client = new PreferenceClient();
            $preference = $client->create([
                "items" => [[
                    "title" => "Alquiler de maquinaria ID {$reserva->maquina_id}",
                    "quantity" => 1,
                    "unit_price" => $reserva->monto_total
                ]],
                "statement_descriptor" => "MANNY Maquinarias",
                "external_reference" => "reserva_" . $reserva->id,
                "metadata" => [
                    "reserva_id" => $reserva->id,
                    "maquina_id" => $reserva->maquina_id,
                    "fecha_inicio" => $reserva->fecha_inicio,
                    "fecha_fin" => $reserva->fecha_fin,
                    "user_id" => $reserva->user_id
                ],
                "back_urls" => [
                    "success" => route('pago.success'),
                    "failure" => route('pago.failure'),
                    "pending" => route('pago.pending')
                ],
                "auto_return" => "approved"
            ]);

            // Podés pasar $preference a la vista, o redirigir al checkout
            return redirect($preference->init_point);
        }
    }

    return redirect()->route('home')->with('error', 'No se encontró una reserva para procesar el pago.');
    }*/
}