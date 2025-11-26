<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\TipoEquipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Mostrar listado de equipos.
     */
    public function index()
    {
        $equipos = Equipo::with('tipoEquipo')
            ->orderBy('numero_serie')
            ->paginate(10);
        return view('equipos.index', compact('equipos'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $tiposEquipo = TipoEquipo::orderBy('descripcion')->get();
        return view('equipos.create', compact('tiposEquipo'));
    }

    /**
     * Almacenar un nuevo equipo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero_serie' => 'required|string|max:100|unique:equipos,numero_serie',
            'descripcion' => 'required|string|max:255',
            'id_tipo' => 'required|exists:tipos_equipo,id',
        ], [
            'numero_serie.required' => 'El número de serie es obligatorio.',
            'numero_serie.unique' => 'Este número de serie ya existe.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'id_tipo.required' => 'Debe seleccionar un tipo de equipo.',
            'id_tipo.exists' => 'El tipo de equipo seleccionado no existe.',
        ]);

        Equipo::create($request->only(['numero_serie', 'descripcion', 'id_tipo']));

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo creado exitosamente.');
    }

    /**
     * Mostrar un equipo específico.
     */
    public function show(Equipo $equipo)
    {
        $equipo->load(['tipoEquipo', 'instalaciones.suministro']);
        return view('equipos.show', compact('equipo'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Equipo $equipo)
    {
        $tiposEquipo = TipoEquipo::orderBy('descripcion')->get();
        return view('equipos.edit', compact('equipo', 'tiposEquipo'));
    }

    /**
     * Actualizar un equipo.
     */
    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'numero_serie' => 'required|string|max:100|unique:equipos,numero_serie,' . $equipo->id,
            'descripcion' => 'required|string|max:255',
            'id_tipo' => 'required|exists:tipos_equipo,id',
        ], [
            'numero_serie.required' => 'El número de serie es obligatorio.',
            'numero_serie.unique' => 'Este número de serie ya existe.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'id_tipo.required' => 'Debe seleccionar un tipo de equipo.',
            'id_tipo.exists' => 'El tipo de equipo seleccionado no existe.',
        ]);

        $equipo->update($request->only(['numero_serie', 'descripcion', 'id_tipo']));

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo actualizado exitosamente.');
    }

    /**
     * Eliminar un equipo.
     */
    public function destroy(Equipo $equipo)
    {
        // Verificar si tiene instalaciones asociadas
        if ($equipo->instalaciones()->count() > 0) {
            return redirect()->route('equipos.index')
                ->with('error', 'No se puede eliminar el equipo porque tiene instalaciones asociadas.');
        }

        $equipo->delete();

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo eliminado exitosamente.');
    }
}
