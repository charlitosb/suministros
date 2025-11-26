<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Mostrar listado de marcas.
     */
    public function index()
    {
        $marcas = Marca::orderBy('descripcion')->paginate(10);
        return view('marcas.index', compact('marcas'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('marcas.create');
    }

    /**
     * Almacenar una nueva marca.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255|unique:marcas,descripcion',
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.unique' => 'Esta marca ya existe.',
        ]);

        Marca::create($request->only('descripcion'));

        return redirect()->route('marcas.index')
            ->with('success', 'Marca creada exitosamente.');
    }

    /**
     * Mostrar una marca específica.
     */
    public function show(Marca $marca)
    {
        $marca->load('suministros');
        return view('marcas.show', compact('marca'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Marca $marca)
    {
        return view('marcas.edit', compact('marca'));
    }

    /**
     * Actualizar una marca.
     */
    public function update(Request $request, Marca $marca)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255|unique:marcas,descripcion,' . $marca->id,
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.unique' => 'Esta marca ya existe.',
        ]);

        $marca->update($request->only('descripcion'));

        return redirect()->route('marcas.index')
            ->with('success', 'Marca actualizada exitosamente.');
    }

    /**
     * Eliminar una marca.
     */
    public function destroy(Marca $marca)
    {
        // Verificar si tiene suministros asociados
        if ($marca->suministros()->count() > 0) {
            return redirect()->route('marcas.index')
                ->with('error', 'No se puede eliminar la marca porque tiene suministros asociados.');
        }

        $marca->delete();

        return redirect()->route('marcas.index')
            ->with('success', 'Marca eliminada exitosamente.');
    }
}
