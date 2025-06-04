<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maquinaria;
use App\Models\TiposMaquinaria;

class MaquinariaController extends Controller
{
    public function create()
    {
        $tipos = TiposMaquinaria::all();
        return view('maquinarias.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable',
            'tipo_id' => 'required|integer',
            'precio_por_dia' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpg,jpeg|max:2048',
            'politica_reembolso' => 'required|in:0,20,100',
            'disclaimer' => 'nullable',
            'anio_produccion' => 'required|integer',
        ], [
            'imagen.mimes' => 'Solo se permiten imágenes en formato JPG o JPEG.',
        ]); 

        // Establecer disponibilidad como "Disponible" por defecto (ID 1, por ejemplo)
          $data = $request->all();
          $data['disponibilidad_id'] = 1;

        if ($request->hasFile('imagen')) {
             $filename = $request->file('imagen')->getClientOriginalName();
             $path = $request->file('imagen')->move(public_path('images'), $filename);
             $data['imagen'] = 'images/' . $filename;
            }


        Maquinaria::create($data);

  

        return redirect('/')->with('success', 'Maquinaria cargada correctamente');
    }

    // lo modifique
    public function show($id)
    {
       $maquinaria = Maquinaria::with('tipo')->findOrFail($id);

        // Get all reserved date ranges for this machine which are still active
        $reservas = \App\Models\Reserva::where('maquina_id', $id)
            ->where(function($q) {
                $q->where('fecha_fin', '>=', now());
            })
            ->get(['fecha_inicio', 'fecha_fin']);

        return view('maquinarias.show', [
            'maquinaria' => $maquinaria,
            'reservas' => $reservas,
        ]);
    }
}
