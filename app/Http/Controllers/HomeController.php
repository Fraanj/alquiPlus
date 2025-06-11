<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Maquinaria;
class HomeController extends Controller
{
    public function index()
    {
        // Para empezar, vamos a mandar datos fijos
        $maquinas = Maquinaria::all();
        $maquinariasEliminadas = Maquinaria::onlyTrashed()->get();
        // Determinar layout según autenticación
        $layout = auth()->check() ? 'layouts.private' : 'layouts.public';

        // Información del usuario para el layout
        // Usar Auth facade es más claro para el IDE
        /** @var User|null $user */ // ← Le dice al IDE: "esta variable es de tipo User"
        $user = Auth::user();
        $userRole = $user?->role;

        return view('home', [
            'layout' => $layout,
            'maquinas' => $maquinas,
            'userRole' => $userRole,
            'maquinariasEliminadas' => $maquinariasEliminadas,
        ]);
    }
}
