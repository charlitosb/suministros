<?php

namespace App\Http\Controllers;

use App\Models\IngresoSuministro;
use App\Models\Suministro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngresoSuministroController extends Controller
{
    /**
     * Mostrar listado de ingresos.
     */
    public function index()
    {
        $ingresos = IngresoSuministro::with(['suministro.marca', 'suministro.categoria'])
            ->orderBy('fecha_ingreso', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('ingresos.index', compact('ingresos'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $suministros = Suministro::with(['marca', 'categoria'])
            ->orderBy('descripcion')
            ->get();
        return view('ingresos.create', compact('suministros'));
    }

    /**
     * Almacenar un nuevo ingreso.
     * IMPORTANTE: Este método incrementa el stock del suministro.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_suministro' => 'required|exists:suministros,id',
            'fecha_ingreso' => 'required|date',
            'cantidad' => 'required|integer|min:1',
        ], [
            'id_suministro.required' => 'Debe seleccionar un suministro.',
            'id_suministro.exists' => 'El suministro seleccionado no existe.',
            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'fecha_ingreso.date' => 'La fecha de ingreso debe ser una fecha válida.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad debe ser al menos 1.',
        ]);

        try {
            DB::beginTransaction();

            // Crear el ingreso (el modelo se encarga de incrementar el stock)
            $ingreso = IngresoSuministro::create($request->only([
                'id_suministro',
                'fecha_ingreso',
                'cantidad'
            ]));

            DB::commit();

            return redirect()->route('ingresos.show', $ingreso)
                ->with('success', 'Ingreso registrado exitosamente. Se han agregado ' . $ingreso->cantidad . ' unidades al stock.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al registrar el ingreso: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de un ingreso.
     * Vista importante para verificar la actualización del stock.
     */
    public function show(IngresoSuministro $ingreso)
    {
        $ingreso->load(['suministro.marca', 'suministro.categoria', 'suministro.tipoEquipo']);
        
        // Obtener el stock actual del suministro
        $stockActual = $ingreso->suministro->stock;
        
        return view('ingresos.show', compact('ingreso', 'stockActual'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(IngresoSuministro $ingreso)
    {
        $suministros = Suministro::with(['marca', 'categoria'])
            ->orderBy('descripcion')
            ->get();
        return view('ingresos.edit', compact('ingreso', 'suministros'));
    }

    /**
     * Actualizar un ingreso.
     * NOTA: Actualizar un ingreso puede afectar el stock.
     */
    public function update(Request $request, IngresoSuministro $ingreso)
    {
        $request->validate([
            'id_suministro' => 'required|exists:suministros,id',
            'fecha_ingreso' => 'required|date',
            'cantidad' => 'required|integer|min:1',
        ], [
            'id_suministro.required' => 'Debe seleccionar un suministro.',
            'id_suministro.exists' => 'El suministro seleccionado no existe.',
            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'fecha_ingreso.date' => 'La fecha de ingreso debe ser una fecha válida.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad debe ser al menos 1.',
        ]);

        try {
            DB::beginTransaction();

            $cantidadAnterior = $ingreso->cantidad;
            $suministroAnterior = $ingreso->id_suministro;
            $suministroNuevo = $request->id_suministro;
            $cantidadNueva = $request->cantidad;

            // Si cambió el suministro, revertir el stock anterior y aplicar al nuevo
            if ($suministroAnterior != $suministroNuevo) {
                // Revertir stock del suministro anterior
                Suministro::where('id', $suministroAnterior)
                    ->decrement('stock', $cantidadAnterior);
                
                // Aplicar stock al nuevo suministro
                Suministro::where('id', $suministroNuevo)
                    ->increment('stock', $cantidadNueva);
            } else {
                // Mismo suministro, ajustar la diferencia
                $diferencia = $cantidadNueva - $cantidadAnterior;
                if ($diferencia > 0) {
                    Suministro::where('id', $suministroNuevo)
                        ->increment('stock', $diferencia);
                } elseif ($diferencia < 0) {
                    // Verificar que no quede stock negativo
                    $suministro = Suministro::find($suministroNuevo);
                    if ($suministro->stock < abs($diferencia)) {
                        throw new \Exception('No se puede reducir la cantidad porque dejaría el stock en negativo.');
                    }
                    Suministro::where('id', $suministroNuevo)
                        ->decrement('stock', abs($diferencia));
                }
            }

            // Actualizar el registro sin disparar eventos
            $ingreso->timestamps = false;
            $ingreso->update([
                'id_suministro' => $suministroNuevo,
                'fecha_ingreso' => $request->fecha_ingreso,
                'cantidad' => $cantidadNueva,
            ]);
            $ingreso->timestamps = true;

            DB::commit();

            return redirect()->route('ingresos.index')
                ->with('success', 'Ingreso actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el ingreso: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar un ingreso.
     * IMPORTANTE: Eliminar un ingreso reduce el stock.
     */
    public function destroy(IngresoSuministro $ingreso)
    {
        try {
            DB::beginTransaction();

            // Verificar que el suministro tenga suficiente stock para revertir
            $suministro = $ingreso->suministro;
            if ($suministro->stock < $ingreso->cantidad) {
                return redirect()->route('ingresos.index')
                    ->with('error', 'No se puede eliminar el ingreso porque el stock actual (' . $suministro->stock . ') es menor a la cantidad del ingreso (' . $ingreso->cantidad . ').');
            }

            // El modelo se encarga de decrementar el stock al eliminar
            $ingreso->delete();

            DB::commit();

            return redirect()->route('ingresos.index')
                ->with('success', 'Ingreso eliminado exitosamente. Se han restado ' . $ingreso->cantidad . ' unidades del stock.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('ingresos.index')
                ->with('error', 'Error al eliminar el ingreso: ' . $e->getMessage());
        }
    }
}
