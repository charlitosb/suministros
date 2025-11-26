<?php

namespace App\Http\Controllers;

use App\Models\InstalacionSuministro;
use App\Models\Suministro;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InstalacionSuministroController extends Controller
{
    /**
     * Mostrar listado de instalaciones.
     */
    public function index()
    {
        $instalaciones = InstalacionSuministro::with([
                'suministro.marca', 
                'suministro.categoria',
                'equipo.tipoEquipo'
            ])
            ->orderBy('fecha_instalacion', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('instalaciones.index', compact('instalaciones'));
    }

    /**
     * Mostrar formulario de creación.
     * Solo muestra suministros con stock disponible.
     */
    public function create()
    {
        // Solo mostrar suministros con stock > 0
        $suministros = Suministro::with(['marca', 'categoria'])
            ->where('stock', '>', 0)
            ->orderBy('descripcion')
            ->get();
        
        $equipos = Equipo::with('tipoEquipo')
            ->orderBy('numero_serie')
            ->get();
        
        // Mensaje si no hay suministros disponibles
        $sinStock = $suministros->isEmpty();
        
        return view('instalaciones.create', compact('suministros', 'equipos', 'sinStock'));
    }

    /**
     * Almacenar una nueva instalación.
     * IMPORTANTE: Este método decrementa el stock del suministro según la cantidad.
     * MÁXIMA PRIORIDAD: Validación robusta de stock.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_suministro' => 'required|exists:suministros,id',
            'id_equipo' => 'required|exists:equipos,id',
            'fecha_instalacion' => 'required|date',
            'cantidad' => 'required|integer|min:1',
        ], [
            'id_suministro.required' => 'Debe seleccionar un suministro.',
            'id_suministro.exists' => 'El suministro seleccionado no existe.',
            'id_equipo.required' => 'Debe seleccionar un equipo.',
            'id_equipo.exists' => 'El equipo seleccionado no existe.',
            'fecha_instalacion.required' => 'La fecha de instalación es obligatoria.',
            'fecha_instalacion.date' => 'La fecha de instalación debe ser una fecha válida.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad mínima es 1.',
        ]);

        try {
            DB::beginTransaction();

            $cantidad = (int) $request->cantidad;

            // VALIDACIÓN CRÍTICA: Verificar stock disponible
            $suministro = Suministro::lockForUpdate()->find($request->id_suministro);
            
            if (!$suministro) {
                throw ValidationException::withMessages([
                    'id_suministro' => ['El suministro seleccionado no existe.']
                ]);
            }

            if ($suministro->stock < $cantidad) {
                throw ValidationException::withMessages([
                    'id_suministro' => [
                        "No hay stock suficiente. " .
                        "Solicitado: {$cantidad}, Disponible: {$suministro->stock}. " .
                        "Debe realizar un ingreso antes de poder instalar."
                    ]
                ]);
            }

            // Crear la instalación (el modelo se encarga de decrementar el stock)
            $instalacion = InstalacionSuministro::create([
                'fecha_instalacion' => $request->fecha_instalacion,
                'id_suministro' => $request->id_suministro,
                'id_equipo' => $request->id_equipo,
                'cantidad' => $cantidad,
            ]);

            DB::commit();

            // Recargar para obtener datos actualizados
            $instalacion->load(['suministro', 'equipo']);

            return redirect()->route('instalaciones.show', $instalacion)
                ->with('success', 
                    "Instalación registrada exitosamente. " .
                    "Se han reducido {$cantidad} unidades del stock de \"{$instalacion->suministro->descripcion}\". " .
                    "Stock actual: " . $instalacion->suministro->fresh()->stock
                );

        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al registrar la instalación: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de una instalación.
     */
    public function show(InstalacionSuministro $instalacione)
    {
        $instalacione->load([
            'suministro.marca', 
            'suministro.categoria', 
            'suministro.tipoEquipo',
            'equipo.tipoEquipo'
        ]);
        
        return view('instalaciones.show', compact('instalacione'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(InstalacionSuministro $instalacione)
    {
        // Incluir el suministro actual aunque no tenga stock
        $suministros = Suministro::with(['marca', 'categoria'])
            ->where(function($query) use ($instalacione) {
                $query->where('stock', '>', 0)
                      ->orWhere('id', $instalacione->id_suministro);
            })
            ->orderBy('descripcion')
            ->get();
        
        $equipos = Equipo::with('tipoEquipo')
            ->orderBy('numero_serie')
            ->get();
        
        return view('instalaciones.edit', compact('instalacione', 'suministros', 'equipos'));
    }

    /**
     * Actualizar una instalación.
     * NOTA: Cambiar el suministro o cantidad afecta el stock.
     */
    public function update(Request $request, InstalacionSuministro $instalacione)
    {
        $request->validate([
            'id_suministro' => 'required|exists:suministros,id',
            'id_equipo' => 'required|exists:equipos,id',
            'fecha_instalacion' => 'required|date',
            'cantidad' => 'required|integer|min:1',
        ], [
            'id_suministro.required' => 'Debe seleccionar un suministro.',
            'id_suministro.exists' => 'El suministro seleccionado no existe.',
            'id_equipo.required' => 'Debe seleccionar un equipo.',
            'id_equipo.exists' => 'El equipo seleccionado no existe.',
            'fecha_instalacion.required' => 'La fecha de instalación es obligatoria.',
            'fecha_instalacion.date' => 'La fecha de instalación debe ser una fecha válida.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad mínima es 1.',
        ]);

        try {
            DB::beginTransaction();

            $suministroAnterior = $instalacione->id_suministro;
            $suministroNuevo = $request->id_suministro;
            $cantidadAnterior = $instalacione->cantidad ?? 1;
            $cantidadNueva = (int) $request->cantidad;

            // Caso 1: Cambió el suministro
            if ($suministroAnterior != $suministroNuevo) {
                // Verificar que el nuevo suministro tenga stock suficiente
                $nuevoSuministro = Suministro::lockForUpdate()->find($suministroNuevo);
                
                if ($nuevoSuministro->stock < $cantidadNueva) {
                    throw ValidationException::withMessages([
                        'id_suministro' => [
                            "No hay stock suficiente en el suministro seleccionado. " .
                            "Solicitado: {$cantidadNueva}, Disponible: {$nuevoSuministro->stock}"
                        ]
                    ]);
                }

                // Devolver stock completo al suministro anterior
                Suministro::where('id', $suministroAnterior)->increment('stock', $cantidadAnterior);
                
                // Decrementar stock del nuevo suministro
                Suministro::where('id', $suministroNuevo)->decrement('stock', $cantidadNueva);
            }
            // Caso 2: Mismo suministro pero diferente cantidad
            elseif ($cantidadAnterior != $cantidadNueva) {
                $suministro = Suministro::lockForUpdate()->find($suministroAnterior);
                $diferencia = $cantidadNueva - $cantidadAnterior;
                
                // Si aumentó la cantidad, verificar que haya stock
                if ($diferencia > 0 && $suministro->stock < $diferencia) {
                    throw ValidationException::withMessages([
                        'cantidad' => [
                            "No hay stock suficiente para aumentar la cantidad. " .
                            "Stock disponible: {$suministro->stock}, Necesario: {$diferencia}"
                        ]
                    ]);
                }
                
                // Ajustar stock según la diferencia
                if ($diferencia > 0) {
                    $suministro->decrement('stock', $diferencia);
                } else {
                    $suministro->increment('stock', abs($diferencia));
                }
            }

            // Actualizar sin disparar eventos del modelo
            $instalacione->timestamps = false;
            $instalacione->update([
                'fecha_instalacion' => $request->fecha_instalacion,
                'id_suministro' => $suministroNuevo,
                'id_equipo' => $request->id_equipo,
                'cantidad' => $cantidadNueva,
            ]);
            $instalacione->timestamps = true;

            DB::commit();

            return redirect()->route('instalaciones.index')
                ->with('success', 'Instalación actualizada exitosamente.');

        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la instalación: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar una instalación.
     * IMPORTANTE: Eliminar una instalación devuelve el stock según la cantidad.
     */
    public function destroy(InstalacionSuministro $instalacione)
    {
        try {
            DB::beginTransaction();

            $suministro = $instalacione->suministro;
            $cantidad = $instalacione->cantidad ?? 1;
            
            // El modelo se encarga de incrementar el stock al eliminar
            $instalacione->delete();

            DB::commit();

            return redirect()->route('instalaciones.index')
                ->with('success', 
                    "Instalación eliminada exitosamente. " .
                    "Se han devuelto {$cantidad} unidades al stock de \"{$suministro->descripcion}\"."
                );

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('instalaciones.index')
                ->with('error', 'Error al eliminar la instalación: ' . $e->getMessage());
        }
    }

    /**
     * API: Obtener stock disponible de un suministro.
     * Para actualización dinámica en el formulario.
     */
    public function getStock($id)
    {
        $suministro = Suministro::find($id);
        
        if (!$suministro) {
            return response()->json(['error' => 'Suministro no encontrado'], 404);
        }

        return response()->json([
            'id' => $suministro->id,
            'descripcion' => $suministro->descripcion,
            'stock' => $suministro->stock,
            'disponible' => $suministro->stock > 0
        ]);
    }
}
