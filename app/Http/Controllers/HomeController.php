<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    public function index()
    {
        // Para empezar, vamos a mandar datos fijos
        $maquinas = [
            [
                'titulo' => 'Tractor John Deere',
                'precio' => 2500,
                'localidad' => 'La Plata',
                'foto' => 'https://via.placeholder.com/150'
            ],
            [
                'titulo' => 'Retroexcavadora CAT',
                'precio' => 3800,
                'localidad' => 'Berazategui',
                'foto' => 'https://via.placeholder.com/150'
            ]
        ];
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
            'userRole' => $userRole
        ]);
    }
}
