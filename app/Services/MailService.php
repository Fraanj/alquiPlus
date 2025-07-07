<?php

namespace App\Services;

use App\Mail\MailPrueba;

class MailService
{
    public static function enviarMailPrueba($email)
    {
        Mail::to($email)->send(new MailPrueba());
    }

    public static function enviarContraseñaMail($email, $contraseña)
    {
        // Mail::to($email)->send(new MailPrueba($contraseña));
    }

    public static function enviarMailCancelacionPorMantenimiento($email, $reserva)
    {
        // Mail::to($email)->send(new MailPrueba($reserva));
    }
}
