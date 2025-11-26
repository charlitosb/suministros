<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Mostrar listado de categorías.
     */
    public function index()
    {
        $categorias = Categoria::orderBy('nombre_categoria')->paginate(10);
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Almacenar una nueva categoría.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:255|unique:categorias,nombre_categoria',
        ], [
            'nombre_categoria.required' => 'El nombre de la categoría es obligatorio.',
            'nombre_categoria.unique' => 'Esta categoría ya existe.',
        ]);

        Categoria::create($request->only('nombre_categoria'));

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Mostrar una categoría específica.
     */
    public function show(Categoria $categoria)
    {
        $categoria->load('suministros');
        return view('categorias.show', compact('categoria'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Actualizar una categoría.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:255|unique:categorias,nombre_categoria,' . $categoria->id,
        ], [
            'nombre_categoria.required' => 'El nombre de la categoría es obligatorio.',
            'nombre_categoria.unique' => 'Esta categoría ya existe.',
        ]);

        $categoria->update($request->only('nombre_categoria'));

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Eliminar una categoría.
     */
    public function destroy(Categoria $categoria)
    {
        // Verificar si tiene suministros asociados
        if ($categoria->suministros()->count() > 0) {
            return redirect()->route('categorias.index')
                ->with('error', 'No se puede eliminar la categoría porque tiene suministros asociados.');
        }

        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }
}
