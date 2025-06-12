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
        ], [
            'fecha_inicio.required' => 'El campo fecha de inicio es obligatorio.',
            'fecha_fin.required' => 'El campo fecha de fin es obligatorio.',
            'fecha_inicio.date' => 'La fecha de inicio no es válida.',
            'fecha_fin.date' => 'La fecha de fin no es válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la de inicio.',
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
    public function confirmarRembolso($id)
    {
        $reserva = reserva::find($id);

        return view('reservas.rembolso', compact('reserva'));
    }

    public function destroy(Request $request)
    {
        $reserva = reserva::find($request->id);
        
        $reserva->delete();
        return redirect()->route('profile.edit')->with('success', 'Reserva cancelada. Devolucion de dinero correspondiente hecha.');
    }


public function pago(Request $request)
{
    $reserva = session('reserva_temporal');

    if (!$reserva) {
        return redirect()->route('home')->with('error', 'No hay reserva temporal.');
    }

    $publicKey = config('services.mercadopago.key');
    MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));

    $client = new PreferenceClient();
    $maquina = Maquinaria::find($reserva->maquina_id);

    try {
        $preference = $client->create([
            "items" => [[
                "title" => $maquina->nombre,
                "quantity" => 1,
                "unit_price" => (float) $reserva->monto_total,
                "currency_id" => "ARS",
                "description" => $maquina->descripcion
            ]],
            "external_reference" => "reserva_" . uniqid(),
            "statement_descriptor" => "MANNY Maquinarias",
            "back_urls" => [
                "success" => "http://localhost/pago/exitoso",
                "failure" => "http://localhost/pago/fallido", 
                "pending" => "http://localhost/pago/pendiente"
            ],
            // Comentar para desarrollo local
            // "auto_return" => "approved",
            //SE ELIMINÓ EL SAVE PORQUE DEBERÍA ESTAR EN SUCCESS NOMÁS.
        ]);
        
    } catch (\MercadoPago\Exceptions\MPApiException $e) {
        return back()->with('error', 'Error al procesar el pago: ' . $e->getMessage());
    }

    // IMPORTANTE: Pasar todos los datos necesarios a la vista
    return view('pagos.create', compact('publicKey', 'preference', 'maquina', 'reserva'));
}

public function success(Request $request)
{
    // Parámetros disponibles:
    $paymentId = $request->get('payment_id');           // ID del pago
    $status = $request->get('status');                  // Estado: approved, pending, rejected
    $externalReference = $request->get('external_reference'); // Tu referencia externa
    $merchantOrder = $request->get('merchant_order_id'); // ID de la orden
    
    // Opcional: Validar el pago con la API
    $payment = new PaymentClient();
    $paymentData = $payment->get($paymentId);
    
    // Procesar la reserva exitosa
    $reserva = session('reserva_temporal');
    if ($reserva && $status === 'approved') {
        // Guardar reserva en BD
        // Limpiar sesión
        session()->forget('reserva_temporal');
    }
    
    return view('pagos.success', compact('paymentData'));
}

public function failure(Request $request)
{
    // Parámetros disponibles:
    $paymentId = $request->get('payment_id');
    $status = $request->get('status');                  // rejected, cancelled
    $externalReference = $request->get('external_reference');
    $statusDetail = $request->get('status_detail');    // Detalle del error
    
    return view('pagos.failure', [
        'error' => 'Pago rechazado o cancelado',
        'status' => $status,
        'statusDetail' => $statusDetail
    ]);
}

public function pending(Request $request)
{
    // Parámetros disponibles:
    $paymentId = $request->get('payment_id');
    $status = $request->get('status');                  // pending
    $externalReference = $request->get('external_reference');
    $statusDetail = $request->get('status_detail');    // pending_waiting_payment, etc.
    
    return view('pagos.pending', [
        'message' => 'Pago pendiente de confirmación',
        'paymentId' => $paymentId,
        'statusDetail' => $statusDetail
    ]);
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