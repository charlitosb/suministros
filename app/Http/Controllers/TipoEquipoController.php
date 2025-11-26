<?php

namespace App\Http\Controllers;

use App\Models\TipoEquipo;
use Illuminate\Http\Request;

class TipoEquipoController extends Controller
{
    /**
     * Mostrar listado de tipos de equipo.
     */
    public function index()
    {
        $tiposEquipo = TipoEquipo::orderBy('descripcion')->paginate(10);
        return view('tipos-equipo.index', compact('tiposEquipo'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('tipos-equipo.create');
    }

    /**
     * Almacenar un nuevo tipo de equipo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255|unique:tipos_equipo,descripcion',
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.unique' => 'Este tipo de equipo ya existe.',
        ]);

        TipoEquipo::create($request->only('descripcion'));

        return redirect()->route('tipos-equipo.index')
            ->with('success', 'Tipo de equipo creado exitosamente.');
    }

    /**
     * Mostrar un tipo de equipo específico.
     */
    public function show(TipoEquipo $tipos_equipo)
    {
        $tipos_equipo->load(['equipos', 'suministros']);
        return view('tipos-equipo.show', compact('tipos_equipo'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(TipoEquipo $tipos_equipo)
    {
        return view('tipos-equipo.edit', compact('tipos_equipo'));
    }

    /**
     * Actualizar un tipo de equipo.
     */
    public function update(Request $request, TipoEquipo $tipos_equipo)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255|unique:tipos_equipo,descripcion,' . $tipos_equipo->id,
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.unique' => 'Este tipo de equipo ya existe.',
        ]);

        $tipos_equipo->update($request->only('descripcion'));

        return redirect()->route('tipos-equipo.index')
            ->with('success', 'Tipo de equipo actualizado exitosamente.');
    }

    /**
     * Eliminar un tipo de equipo.
     */
    public function destroy(TipoEquipo $tipos_equipo)
    {
        // Verificar si tiene equipos asociados
        if ($tipos_equipo->equipos()->count() > 0) {
            return redirect()->route('tipos-equipo.index')
                ->with('error', 'No se puede eliminar el tipo de equipo porque tiene equipos asociados.');
        }

        // Verificar si tiene suministros asociados
        if ($tipos_equipo->suministros()->count() > 0) {
            return redirect()->route('tipos-equipo.index')
                ->with('error', 'No se puede eliminar el tipo de equipo porque tiene suministros asociados.');
        }

        $tipos_equipo->delete();

        return redirect()->route('tipos-equipo.index')
            ->with('success', 'Tipo de equipo eliminado exitosamente.');
    }
}
