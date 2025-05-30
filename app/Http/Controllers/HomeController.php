<?php

namespace App\Http\Controllers;

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

        return view('home', compact('maquinas'));
    }
}