<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maquinaria;
use App\Models\TiposMaquinaria;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar Auth

class MaquinariaController extends Controller
{
    // MÉTODOS PARA MAQUINARIAS ACTIVAS (CRUD estándar)

    public function create()
    {
        $tipos = TiposMaquinaria::all();
        $sucursales = Maquinaria::getSucursales();
        return view('maquinarias.create', compact('tipos', 'sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|alpha_num|size:6|unique:maquinarias,codigo',
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable',
            'tipo_id' => 'required|integer|exists:tipos_maquinaria,id',
            'precio_por_dia' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'politica_reembolso' => 'required|in:0,20,100',
            'disclaimer' => 'nullable',
            'anio_produccion' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'sucursal' => 'required|in:'.implode(',',Maquinaria::SUCURSALES),
        ], [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.string' => 'El código debe ser una cadena de texto.',
            'codigo.alpha_num' => 'El código solo puede contener letras y números.',
            'codigo.size' => 'El código debe tener exactamente 6 caracteres.',
            'codigo.unique' => 'Este código ya está en uso.',
            'tipo_id.exists' => 'El tipo de maquinaria seleccionado no es válido.',
            'imagen.mimes' => 'Solo se permiten imágenes en formato JPG, JPEG o PNG.',
            'sucursal.required' => 'Debe seleccionar una sucursal.',
            'sucursal.in' => 'La sucursal seleccionada no es válida.',
            'anio_produccion.min' => 'El año de producción no es válido.',
            'anio_produccion.max' => 'El año de producción no puede ser futuro.',
        ]);

        $data = $request->all();
        $data['disponibilidad_id'] = 1; // Por defecto disponible

        if ($request->hasFile('imagen')) {
            $nombreImagen = time() . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('images'), $nombreImagen);
            $data['imagen'] = $nombreImagen;
        }

        Maquinaria::create($data);

        return redirect('/')->with('success', 'Maquinaria cargada correctamente'); // O a la ruta que prefieras
    }

    /**
     * Display the specified active (not soft-deleted) resource.
     * Accesible por cualquier usuario.
     */
    public function show($id)
    {
        // findOrFail por defecto NO encontrará registros soft-deleted.
        $maquinaria = Maquinaria::with('tipo')->findOrFail($id);

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
        $maquinaria = Maquinaria::findOrFail($id); // No debe permitir editar eliminadas
        $tipos = TiposMaquinaria::all();
        $sucursales = Maquinaria::getSucursales();
        return view('maquinarias.edit', compact('maquinaria', 'tipos', 'sucursales'));
    }

    public function update(Request $request, $id)
    {
        $maquinaria = Maquinaria::findOrFail($id); // No debe permitir actualizar eliminadas

        $request->validate([
            'codigo' => [
                'required',
                'string',
                'alpha_num',
                'size:6',
                Rule::unique('maquinarias', 'codigo')->ignore($maquinaria->id),
            ],
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_por_dia' => 'required|numeric|min:0',
            'anio_produccion' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'tipo_id' => 'nullable|exists:tipos_maquinaria,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sucursal' => 'required|in:'.implode(',',Maquinaria::SUCURSALES),
        ], [
            // ... mensajes de validación como en store ...
            'codigo.required' => 'El código es obligatorio.',
            'codigo.unique' => 'Este código ya está en uso.',
            'sucursal.required' => 'Debe seleccionar una sucursal.',
        ]);

        $dataToUpdate = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            if ($maquinaria->imagen && file_exists(public_path('images/' . $maquinaria->imagen))) {
                unlink(public_path('images/' . $maquinaria->imagen));
            }
            $nombreImagen = time() . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('images'), $nombreImagen);
            $dataToUpdate['imagen'] = $nombreImagen;
        }

        $maquinaria->update($dataToUpdate);

        return redirect()->route('maquinarias.show', $maquinaria->id)->with('success', 'Maquinaria editada correctamente');
    }

    public function confirmDelete($id)
    {
        $maquinaria = Maquinaria::findOrFail($id);
        return view('maquinarias.delete', compact('maquinaria'));
    }

    public function destroy($id)
    {
        $maquinaria = Maquinaria::findOrFail($id);
        // No borramos el archivo de imagen en un soft delete.
        $maquinaria->delete();
        return redirect('/')->with('success', 'Maquinaria eliminada correctamente.');
    }

    // --- MÉTODOS PARA MAQUINARIAS ELIMINADAS SUAVEMENTE (Solo Admin) ---

    /**
     * Display a listing of the soft-deleted resources.
     * Solo para administradores.
     */
    public function indexSoftDeleted()
    {
        // Esta verificación es redundante si proteges la ruta con middleware 'admin'
        // if (!Auth::check() || !Auth::user()->isAdmin()) {
        //     abort(403, 'Acceso no autorizado.');
        // }
        $maquinasEliminadas = Maquinaria::onlyTrashed()->with('tipo')->latest('deleted_at')->paginate(10);
        return view('maquinarias.index-soft-deleted', compact('maquinasEliminadas'));
    }

    /**
     * Display the specified soft-deleted resource.
     * Solo para administradores.
     */
    public function showSoftDeleted($id)
    {
        $maquinaria = Maquinaria::onlyTrashed()->with('tipo')->findOrFail($id);
        // Para la vista 'show-soft-deleted', no necesitas pasar 'reservas' o puedes pasar una colección vacía.
        return view('maquinarias.show-soft-deleted', [
            'maquinaria' => $maquinaria,
            // 'isSoftDeletedView' => true, // Opcional, si la vista necesita saberlo
        ]);
    }

    /**
     * Restore the specified soft-deleted resource.
     * Solo para administradores.
     */
    public function restore($id)
    {
        $maquinaria = Maquinaria::onlyTrashed()->findOrFail($id);
        $maquinaria->restore();
        return redirect()->route('maquinarias.index.soft-deleted')->with('success', 'Maquinaria restaurada correctamente.');
    }

    /**
     * Permanently delete the specified resource from storage.
     * Solo para administradores.
     */
}
