<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maquinaria;
use App\Models\TiposMaquinaria;
use Illuminate\Validation\Rule;

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
            'codigo' => 'required|string|alpha_num|size:6|unique:maquinarias,codigo', // Validación para el código
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
            'codigo.required' => 'El código es obligatorio.',
            'codigo.string' => 'El código debe ser una cadena de texto.',
            'codigo.alpha_num' => 'El código solo puede contener letras y números.',
            'codigo.size' => 'El código debe tener exactamente 6 caracteres.',
            'codigo.unique' => 'Este código ya está en uso.',
            'tipo_id.required' => 'Debes elegir un tipo de maquinaria',
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
            'codigo' => [
                'required',
                'string',
                'alpha_num',
                'size:6',
                Rule::unique('maquinarias', 'codigo')->ignore($maquinaria->id), // Validación que ignora el registro actual
            ],
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_por_dia' => 'required|numeric|min:0',
            'anio_produccion' => 'required|integer|max:' . date('Y'),
            'tipo_id' => 'nullable|exists:tipos_maquinaria,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sucursal' => 'required|in:La Plata,Berisso,Ensenada',
        ], [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.string' => 'El código debe ser una cadena de texto.',
            'codigo.alpha_num' => 'El código solo puede contener letras y números.',
            'codigo.size' => 'El código debe tener exactamente 6 caracteres.',
            'codigo.unique' => 'Este código ya está en uso.',
            'sucursal.required' => 'Debe seleccionar una sucursal.',
            'sucursal.in' => 'La sucursal seleccionada no es válida.',
            'anio_produccion.max' => 'El año no puede ser mayor al actual.',
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

        // Deslinkea ("borra") imagen asociada. es mejor que esto no este
            // if ($maquinaria->imagen && file_exists(public_path('images/' . $maquinaria->imagen))) {
            //     unlink(public_path('images/' . $maquinaria->imagen));
            // }
        if ($maquinaria->tieneReservasPendientes()) {
            // esto no deberia ser success pero no muestra el mensaje si uso error
            return redirect('/')->with('false', 'No se puede eliminar la maquina debido a que tiene reservas pendientes.');
        }
        $maquinaria->delete();
        return redirect('/')->with('success', 'Maquinaria eliminada correctamente.');
    }

    public function restore($id)
    {
        $maquinaria = Maquinaria::onlyTrashed()->findOrFail($id);
        $maquinaria->restore();

        return redirect('/')->with('success', 'Maquinaria restaurada correctamente.');
    }

    public function maintenanceForm($id)
    {
        $maquinaria = Maquinaria::findOrFail($id);
        return view('maquinarias.maintenance', compact('maquinaria'));
    }

    public function startMaintenance(Request $request, $id)
    {
        $request->validate([
            'fecha_inicio' => 'required|date|after_or_equal:yesterday',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ], [
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.after_or_equal' => 'La fecha de inicio no puede ser anterior a hoy.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
        ]);

        $maquinaria = Maquinaria::findOrFail($id);
        
        $ReservasPendientes = \App\Models\Reserva::where('maquina_id', $id)
            ->where('fecha_inicio', '>=', $request->fecha_inicio)
            ->where('fecha_fin', '<=', $request->fecha_fin)
            ->where('estado', '=', 'pendiente')
            ->get();

        if ($ReservasPendientes->isNotEmpty()) {
            // Cancelar reservas que coincidan con las fechas
            foreach ($ReservasPendientes as $reserva) {
                $reserva->cancelar(); 
                $reserva->save();
                
                // Enviar email de cancelación
                \App\Services\MailService::enviarMailCancelacionPorMantenimiento($reserva->usuario->email, $reserva);
            }
        }

        $maquinaria->disponibilidad_id = 3; // En mantenimiento
        $maquinaria->save();

        return redirect('/')->with('success', 'Mantenimiento programado correctamente del ' . $request->fecha_inicio . ' al ' . $request->fecha_fin);
    }

    public function endMaintenance($id)
    {
        $maquinaria = Maquinaria::findOrFail($id);
        $maquinaria->disponibilidad_id = 1; // ID 1 para "Disponible"
        $maquinaria->save();

        return redirect('/')->with('success', 'Final del mantenimiento registrado correctamente.');
    }
}
