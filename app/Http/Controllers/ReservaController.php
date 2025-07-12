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
use MercadoPago\Client\Payment\PaymentClient; // 👈 Agregar esta línea

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

        //skippear pagor
        $reserva->save();
        session()->forget('reserva_temporal');
        return redirect()->route('home')->with('success', 'Reserva creada exitosamente. Por favor, proceda al pago.');

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

        $reserva->cancelar();
        
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
        $maquina = Maquinaria::find($reserva->maquina_id);        $maquina = Maquinaria::find($reserva->maquina_id);


        // 🌐 OBTENER LA URL BASE DINÁMICA
        $baseUrl = $this->getPublicUrl();

        // 🔑 CREAR ID ÚNICO PARA LA RESERVA
        $reservaId = 'reserva_' . uniqid();

        // 💾 GUARDAR DATOS EN CACHÉ POR 30 MINUTOS
        \Cache::put($reservaId, [
            'maquina_id' => $reserva->maquina_id,
            'user_id' => $reserva->user_id,
            'fecha_inicio' => $reserva->fecha_inicio,
            'fecha_fin' => $reserva->fecha_fin,
            'monto_total' => $reserva->monto_total,
            'fecha_reserva' => $reserva->fecha_reserva
        ], 1800); // 30 minutos

        \Log::info('DATOS GUARDADOS EN CACHE', [
            'reserva_id' => $reservaId,
            'datos' => \Cache::get($reservaId)
        ]);

        try {
            $preference = $client->create([
                "items" => [[
                    "title" => $maquina->nombre,
                    "quantity" => 1,
                    "unit_price" => (float) $reserva->monto_total,
                    "currency_id" => "ARS",
                    "description" => $maquina->descripcion
                ]],
                "payer" => [
                    "email" => Auth::user()->email,
                ],
                "external_reference" => $reservaId, // 👈 USAR NUESTRO ID
                "statement_descriptor" => "MANNY Maquinarias",
                "back_urls" => [
                    "success" => $baseUrl . "/pago/exitoso",
                    "failure" => $baseUrl . "/pago/fallido",
                    "pending" => $baseUrl . "/pago/pendiente"
                ],
                "auto_return" => "approved",
            ]);

            \Log::info('PREFERENCIA CREADA', [
                'preference_id' => $preference->id,
                'external_reference' => $preference->external_reference,
                'back_urls' => $preference->back_urls
            ]);

        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            return back()->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }

        return view('pagos.create', compact('publicKey', 'preference', 'maquina', 'reserva'));
    }

    // 🌐 MÉTODO PARA OBTENER URL PÚBLICA
    private function getPublicUrl()
    {
        // En desarrollo con Cloudflare Tunnel
        if (config('app.env') === 'local') {
            return config('app.public_url', config('app.url'));
        }

        // En producción
        return config('app.url');
    }

    public function success(Request $request)
    {
        $paymentId = $request->get('payment_id');
        $status = $request->get('status');
        $externalReference = $request->get('external_reference');

        \Log::info('=== DEBUG SUCCESS METHOD ===', [
            'payment_id' => $paymentId,
            'status' => $status,
            'external_reference' => $externalReference,
            'all_request' => $request->all()
        ]);

        // 🔒 VALIDAR EL PAGO CON LA API
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));
        $paymentClient = new PaymentClient();

        try {
            \Log::info('=== ANTES DE LLAMAR A LA API ===');
            $paymentData = $paymentClient->get($paymentId);
            \Log::info('=== API RESPONSE OK ===');

            if ($status === 'approved' && $externalReference) {
                \Log::info('=== PAGO APROBADO - BUSCANDO EN CACHE ===');

                // 📦 OBTENER DATOS DEL CACHÉ
                $datosReserva = \Cache::get($externalReference);

                \Log::info('=== DATOS DE CACHE ===', [
                    'external_reference' => $externalReference,
                    'datos_encontrados' => $datosReserva !== null,
                    'datos' => $datosReserva
                ]);

                if ($datosReserva) {
                    \Log::info('=== CREANDO RESERVA ===');

                    // 💾 CREAR RESERVA CON LOS DATOS DEL CACHÉ
                    $nuevaReserva = new Reserva();
                    $nuevaReserva->maquina_id = $datosReserva['maquina_id'];
                    $nuevaReserva->user_id = $datosReserva['user_id'];
                    $nuevaReserva->fecha_inicio = $datosReserva['fecha_inicio'];
                    $nuevaReserva->fecha_fin = $datosReserva['fecha_fin'];
                    $nuevaReserva->monto_total = $datosReserva['monto_total'];
                    $nuevaReserva->fecha_reserva = $datosReserva['fecha_reserva'];

                    \Log::info('=== ANTES DE GUARDAR EN BD ===');
                    $nuevaReserva->save();
                    \Log::info('=== GUARDADO EN BD OK ===');

                    // Limpiar caché y sesión
                    \Cache::forget($externalReference);
                    session()->forget('reserva_temporal');

                    return view('pagos.exitoso', compact('paymentData', 'nuevaReserva'));
                }
            }

        } catch (\Exception $e) {
            \Log::error('=== EXCEPCIÓN CAPTURADA ===', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('pago.fallido')->with('error', 'Error al validar el pago');
        }

        return redirect()->route('home')->with('error', 'Pago no válido');
    }

    public function failure(Request $request)
    {
        //dd('FAILURE CALLBACK', $request->all()); LINEA PARA DEBUG.
        $paymentId = $request->get('payment_id');
        $status = $request->get('status');
        $externalReference = $request->get('external_reference');
        $statusDetail = $request->get('status_detail');

        return view('pagos.fallido', [
            'error' => 'Pago rechazado o cancelado',
            'status' => $status,
            'statusDetail' => $statusDetail
        ]);
    }

    public function pending(Request $request)
    {
        // dd('PENDING CALLBACK', $request->all()); línea que muestra para debuguear.
        $paymentId = $request->get('payment_id');
        $status = $request->get('status');
        $externalReference = $request->get('external_reference');
        $statusDetail = $request->get('status_detail');

        return view('pagos.pendiente', [
            'message' => 'Pago pendiente de confirmación',
            'paymentId' => $paymentId,
            'statusDetail' => $statusDetail
        ]);
    }

    public function historialReservas()
    {
        $reservas = Reserva::all();

        return view('reservas.historialReservas', compact('reservas'));
    }

    public function confirmada($reservaId)
    {
        $reserva = Reserva::findOrFail($reservaId);
        // dd("dfg"); // Quitar esto
        $reserva->maquinaria->entregada();
        $reserva->estado = 'confirmada';
        $reserva->save();
        return redirect()->back();
    }

    public function completada($reservaId)
    {
        $reservas = Reserva::findOrFail($reservaId);

        if (Carbon::today() > $reservas->fecha_fin) {
            $diasRetrasados = Carbon::today()->diffInDays($reservas->fecha_fin, true);
            $extra = $diasRetrasados * $reservas->maquinaria->precio_por_dia / 2; // 50% de recargo por día de retraso
            \App\Services\MailService::enviarMailRetrasoEntrega($reservas->usuario->email, $reservas, $extra, $diasRetrasados);
        }

        $reservas->maquinaria->recibida();
        $reservas->estado = 'completada';
        $reservas->save();
        return redirect()->back();
    }

    public function cancelar(Reserva $reserva)
    {
        if ($reserva->estado != 'pendiente') {
            return redirect()->back()->with('error', 'La reserva no se puede cancelar');
        }
        $reserva->cancelar(); // Usa tu método existente

        \App\Services\MailService::enviarMailCancelacionManual($reserva->usuario->email, $reserva);

        return redirect()->back()->with('success', 'Reserva cancelada correctamente. Se envio un mail al usuario');
    }
}