<?php

namespace App\Http\Controllers;

use App\Models\Suministro;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\TipoEquipo;
use Illuminate\Http\Request;

class SuministroController extends Controller
{
    /**
     * Mostrar listado de suministros.
     */
    public function index()
    {
        $suministros = Suministro::with(['marca', 'categoria', 'tipoEquipo'])
            ->orderBy('descripcion')
            ->paginate(10);
        return view('suministros.index', compact('suministros'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $marcas = Marca::orderBy('descripcion')->get();
        $categorias = Categoria::orderBy('nombre_categoria')->get();
        $tiposEquipo = TipoEquipo::orderBy('descripcion')->get();
        
        return view('suministros.create', compact('marcas', 'categorias', 'tiposEquipo'));
    }

    /**
     * Almacenar un nuevo suministro.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'id_marca' => 'required|exists:marcas,id',
            'id_categoria' => 'required|exists:categorias,id',
            'id_tipo_equipo' => 'required|exists:tipos_equipo,id',
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',
            'id_marca.required' => 'Debe seleccionar una marca.',
            'id_marca.exists' => 'La marca seleccionada no existe.',
            'id_categoria.required' => 'Debe seleccionar una categoría.',
            'id_categoria.exists' => 'La categoría seleccionada no existe.',
            'id_tipo_equipo.required' => 'Debe seleccionar un tipo de equipo.',
            'id_tipo_equipo.exists' => 'El tipo de equipo seleccionado no existe.',
        ]);

        // El stock siempre inicia en 0
        $data = $request->only(['descripcion', 'precio', 'id_marca', 'id_categoria', 'id_tipo_equipo']);
        $data['stock'] = 0;

        Suministro::create($data);

        return redirect()->route('suministros.index')
            ->with('success', 'Suministro creado exitosamente. El stock inicial es 0, realice un ingreso para agregar stock.');
    }

    /**
     * Mostrar un suministro específico.
     */
    public function show(Suministro $suministro)
    {
        $suministro->load(['marca', 'categoria', 'tipoEquipo', 'ingresos', 'instalaciones.equipo']);
        return view('suministros.show', compact('suministro'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Suministro $suministro)
    {
        $marcas = Marca::orderBy('descripcion')->get();
        $categorias = Categoria::orderBy('nombre_categoria')->get();
        $tiposEquipo = TipoEquipo::orderBy('descripcion')->get();
        
        return view('suministros.edit', compact('suministro', 'marcas', 'categorias', 'tiposEquipo'));
    }

    /**
     * Actualizar un suministro.
     */
    public function update(Request $request, Suministro $suministro)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'id_marca' => 'required|exists:marcas,id',
            'id_categoria' => 'required|exists:categorias,id',
            'id_tipo_equipo' => 'required|exists:tipos_equipo,id',
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',
            'id_marca.required' => 'Debe seleccionar una marca.',
            'id_marca.exists' => 'La marca seleccionada no existe.',
            'id_categoria.required' => 'Debe seleccionar una categoría.',
            'id_categoria.exists' => 'La categoría seleccionada no existe.',
            'id_tipo_equipo.required' => 'Debe seleccionar un tipo de equipo.',
            'id_tipo_equipo.exists' => 'El tipo de equipo seleccionado no existe.',
        ]);

        // No permitir modificar el stock directamente
        $suministro->update($request->only(['descripcion', 'precio', 'id_marca', 'id_categoria', 'id_tipo_equipo']));

        return redirect()->route('suministros.index')
            ->with('success', 'Suministro actualizado exitosamente.');
    }

    /**
     * Eliminar un suministro.
     */
    public function destroy(Suministro $suministro)
    {
        // Verificar si tiene ingresos asociados
        if ($suministro->ingresos()->count() > 0) {
            return redirect()->route('suministros.index')
                ->with('error', 'No se puede eliminar el suministro porque tiene ingresos asociados.');
        }

        // Verificar si tiene instalaciones asociadas
        if ($suministro->instalaciones()->count() > 0) {
            return redirect()->route('suministros.index')
                ->with('error', 'No se puede eliminar el suministro porque tiene instalaciones asociadas.');
        }

        $suministro->delete();

        return redirect()->route('suministros.index')
            ->with('success', 'Suministro eliminado exitosamente.');
    }
}
