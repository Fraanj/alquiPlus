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
        $sucursales = Maquinaria::getSucursales();
        return view('maquinarias.create', compact('tipos', 'sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable',
            'tipo_id' => 'required|integer',
            'precio_por_dia' => 'required|numeric|min:0',
            'imagen' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'politica_reembolso' => 'required|in:0,20,100',
            'disclaimer' => 'nullable',
            'anio_produccion' => 'required|integer|max:' . date('Y'),
            'sucursal' => 'required|in:La Plata,Berisso,Ensenada',
        ], [
            'imagen.mimes' => 'Solo se permiten imágenes en formato JPG, JPEG o PNG.',
            'sucursal.required' => 'Debe seleccionar una sucursal.',
            'sucursal.in' => 'La sucursal seleccionada no es válida.',
            'anio_produccion.max' => 'El año no puede ser mayor al actual.',
            'imagen.required' => 'La imagen es obligatoria.',

        ]);

        // Establecer disponibilidad como "Disponible" por defecto (ID 1)
        $data = $request->all();
        $data['disponibilidad_id'] = 1;

        if ($request->hasFile('imagen')) {
            $nombreImagen = time() . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('images'), $nombreImagen);
            $data['imagen'] = $nombreImagen;
        }

        Maquinaria::create($data);

        return redirect('/')->with('success', 'Maquinaria cargada correctamente');
    }

    public function show($id)
    {
        $maquinaria = Maquinaria::with('tipo')->findOrFail($id);

        // Get all reserved date ranges for this machine which are still active
        $reservas = \App\Models\Reserva::where('maquina_id', $id)
            ->where('fecha_fin', '>=', \Carbon\Carbon::yesterday())
            ->get(['fecha_inicio', 'fecha_fin']);

        return view('maquinarias.show', [
            'maquinaria' => $maquinaria,
            'reservas' => $reservas,
        ]);
    }

    public function edit($id)
    {
        $maquinaria = Maquinaria::findOrFail($id);
        $tipos = TiposMaquinaria::all();
        $sucursales = Maquinaria::getSucursales();
        return view('maquinarias.edit', compact('maquinaria', 'tipos', 'sucursales'));
    }

    public function update(Request $request, $id)
    {
        $maquinaria = Maquinaria::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_por_dia' => 'required|numeric|min:0',
            'anio_produccion' => 'required|integer',
            'tipo_id' => 'nullable|exists:tipos_maquinaria,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sucursal' => 'required|in:La Plata,Berisso,Ensenada',
        ], [
            'sucursal.required' => 'Debe seleccionar una sucursal.',
            'sucursal.in' => 'La sucursal seleccionada no es válida.',
        ]);

        $maquinaria->fill($request->except('imagen'));

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($maquinaria->imagen && file_exists(public_path('images/' . $maquinaria->imagen))) {
                unlink(public_path('images/' . $maquinaria->imagen));
            }

            $nombreImagen = time() . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('images'), $nombreImagen);
            $maquinaria->imagen = $nombreImagen;
        }

        $maquinaria->save();

        return redirect('/')->with('success', 'Maquinaria editada correctamente');
    }

    public function confirmDelete($id)
    {
        $maquinaria = Maquinaria::findOrFail($id);
        return view('maquinarias.delete', compact('maquinaria'));
    }

    public function destroy($id)
    {
        $maquinaria = Maquinaria::findOrFail($id);

        // Si hay imagen asociada, la borra
        if ($maquinaria->imagen && file_exists(public_path('images/' . $maquinaria->imagen))) {
            unlink(public_path('images/' . $maquinaria->imagen));
        }

        $maquinaria->delete();

        return redirect('/')->with('success', 'Maquinaria eliminada correctamente.');
    }
}
