<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MailPrueba;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Send a test email.
     */
    public function sendTestEmail()
    {
        // Send the email
        Mail::to('mastrangelolautaro19@gmail.com')->send(new MailPrueba());
        
        return redirect("/")->with('success', 'Email enviado correctamente.');
    }
}