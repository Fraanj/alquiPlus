<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MailPrueba;
use Illuminate\Support\Facades\Mail;
use App\Services\MailService;
use App\Models\Reserva;
// use App\Mail\MailCancelacionPorMantenimiento;
// use App\Mail\mailPasswordEmpleado;

class MailController extends Controller
{
    // ESTO ES SOLO PARA PRUEBAS

    /**
     * Send a test email.
     */
    public function sendTestEmail()
    {
        // Send the email
        Mail::to('mastrangelolautaro19@gmail.com')->send(new MailPrueba());
        
        return redirect("/")->with('success', 'Email enviado correctamente.');
    }

    public function sendPasswordEmail()
    {
        mailService::enviarContraseñaMail('mastrangelolautaro19@gmail.com', 'contraseña123');
        return redirect("/")->with('success', 'Email de contraseña enviado correctamente.');
    }
 
    public function sendCancelacionMantenimientoEmail()
    {
        $reserva = Reserva::find(3);
        mailService::enviarMailCancelacionPorMantenimiento('mastrangelolautaro19@gmail.com', $reserva);
        return redirect("/")->with('success', 'Email de cancelación por mantenimiento enviado correctamente.');
    }
}