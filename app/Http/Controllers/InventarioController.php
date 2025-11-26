<?php

namespace App\Http\Controllers;

use App\Models\Suministro;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\TipoEquipo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InventarioController extends Controller
{
    /**
     * Mostrar vista de inventario con filtros.
     */
    public function index(Request $request)
    {
        // Obtener datos para los filtros
        $categorias = Categoria::orderBy('nombre_categoria')->get();
        $marcas = Marca::orderBy('descripcion')->get();
        $tiposEquipo = TipoEquipo::orderBy('descripcion')->get();

        // Construir la consulta con filtros
        $query = Suministro::with(['marca', 'categoria', 'tipoEquipo']);

        // Filtro por categoría
        if ($request->filled('categoria_id')) {
            $query->where('id_categoria', $request->categoria_id);
        }

        // Filtro por marca
        if ($request->filled('marca_id')) {
            $query->where('id_marca', $request->marca_id);
        }

        // Filtro por tipo de equipo
        if ($request->filled('tipo_equipo_id')) {
            $query->where('id_tipo_equipo', $request->tipo_equipo_id);
        }

        // Filtro por estado de stock
        if ($request->filled('estado_stock')) {
            switch ($request->estado_stock) {
                case 'sin_stock':
                    $query->where('stock', 0);
                    break;
                case 'bajo_stock':
                    $query->where('stock', '>', 0)->where('stock', '<=', 5);
                    break;
                case 'con_stock':
                    $query->where('stock', '>', 5);
                    break;
            }
        }

        // Filtro por búsqueda de texto
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('descripcion', 'like', "%{$buscar}%")
                  ->orWhereHas('marca', function($q2) use ($buscar) {
                      $q2->where('descripcion', 'like', "%{$buscar}%");
                  });
            });
        }

        // Ordenamiento
        $ordenarPor = $request->get('ordenar_por', 'descripcion');
        $ordenarDir = $request->get('ordenar_dir', 'asc');
        
        $camposOrden = ['descripcion', 'stock', 'precio', 'created_at'];
        if (in_array($ordenarPor, $camposOrden)) {
            $query->orderBy($ordenarPor, $ordenarDir);
        }

        // Obtener resultados paginados
        $suministros = $query->paginate(15)->withQueryString();

        // Estadísticas generales
        $estadisticas = [
            'total' => Suministro::count(),
            'sin_stock' => Suministro::where('stock', 0)->count(),
            'bajo_stock' => Suministro::where('stock', '>', 0)->where('stock', '<=', 5)->count(),
            'con_stock' => Suministro::where('stock', '>', 5)->count(),
            'valor_total' => Suministro::selectRaw('SUM(precio * stock) as total')->value('total') ?? 0,
        ];

        return view('inventario.index', compact(
            'suministros', 
            'categorias', 
            'marcas', 
            'tiposEquipo',
            'estadisticas'
        ));
    }

    /**
     * Generar reporte PDF del inventario.
     */
    public function exportarPdf(Request $request)
    {
        // Construir la consulta con los mismos filtros
        $query = Suministro::with(['marca', 'categoria', 'tipoEquipo']);

        // Aplicar filtros
        if ($request->filled('categoria_id')) {
            $query->where('id_categoria', $request->categoria_id);
        }

        if ($request->filled('marca_id')) {
            $query->where('id_marca', $request->marca_id);
        }

        if ($request->filled('tipo_equipo_id')) {
            $query->where('id_tipo_equipo', $request->tipo_equipo_id);
        }

        if ($request->filled('estado_stock')) {
            switch ($request->estado_stock) {
                case 'sin_stock':
                    $query->where('stock', 0);
                    break;
                case 'bajo_stock':
                    $query->where('stock', '>', 0)->where('stock', '<=', 5);
                    break;
                case 'con_stock':
                    $query->where('stock', '>', 5);
                    break;
            }
        }

        // Filtro por búsqueda de texto
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('descripcion', 'like', "%{$buscar}%")
                  ->orWhereHas('marca', function($q2) use ($buscar) {
                      $q2->where('descripcion', 'like', "%{$buscar}%");
                  });
            });
        }

        $suministros = $query->orderBy('descripcion')->get();

        // Obtener información de filtros aplicados
        $filtrosAplicados = [];
        
        if ($request->filled('categoria_id')) {
            $categoria = Categoria::find($request->categoria_id);
            if ($categoria) {
                $filtrosAplicados['Categoría'] = $categoria->nombre_categoria;
            }
        }

        if ($request->filled('marca_id')) {
            $marca = Marca::find($request->marca_id);
            if ($marca) {
                $filtrosAplicados['Marca'] = $marca->descripcion;
            }
        }

        if ($request->filled('tipo_equipo_id')) {
            $tipo = TipoEquipo::find($request->tipo_equipo_id);
            if ($tipo) {
                $filtrosAplicados['Tipo Equipo'] = $tipo->descripcion;
            }
        }

        if ($request->filled('estado_stock')) {
            $estados = [
                'sin_stock' => 'Sin Stock',
                'bajo_stock' => 'Stock Bajo (≤5)',
                'con_stock' => 'Con Stock (>5)'
            ];
            $filtrosAplicados['Estado'] = $estados[$request->estado_stock] ?? '';
        }

        if ($request->filled('buscar')) {
            $filtrosAplicados['Búsqueda'] = $request->buscar;
        }

        // Calcular totales
        $totalStock = $suministros->sum('stock');
        $valorTotal = $suministros->sum(function($s) {
            return $s->precio * $s->stock;
        });

        $pdf = Pdf::loadView('inventario.pdf', compact(
            'suministros', 
            'filtrosAplicados',
            'totalStock',
            'valorTotal'
        ));

        $pdf->setPaper('letter', 'landscape');

        $nombreArchivo = 'inventario_suministros_' . date('Y-m-d_His') . '.pdf';

        return $pdf->download($nombreArchivo);
    }
}
