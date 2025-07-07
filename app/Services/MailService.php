<?php

namespace App\Services;

use App\Mail\MailPrueba;
use App\Mail\MailCancelacionPorMantenimiento;
use App\Mail\mailPasswordEmpleado;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public static function enviarMailPrueba($email)
    {
        Mail::to($email)->send(new MailPrueba());
    }

    public static function enviarContraseñaMail($email, $contraseña)
    {
        Mail::to($email)->send(new MailPasswordEmpleado($contraseña));
    }

    public static function enviarMailCancelacionPorMantenimiento($email, $reserva)
    {
        // dd('dd 1');
        Mail::to($email)->send(new MailCancelacionPorMantenimiento($reserva));
        dd('dd 2. Email enviado correctamente con la reserva: ' . $reserva->id);
    }
}
