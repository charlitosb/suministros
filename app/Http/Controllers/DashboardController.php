<?php

namespace App\Http\Controllers;

use App\Models\Suministro;
use App\Models\Equipo;
use App\Models\IngresoSuministro;
use App\Models\InstalacionSuministro;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard de bienvenida.
     */
    public function index()
    {
        // Estadísticas básicas para el dashboard
        $estadisticas = [
            'total_suministros' => Suministro::count(),
            'total_equipos' => Equipo::count(),
            'total_ingresos' => IngresoSuministro::count(),
            'total_instalaciones' => InstalacionSuministro::count(),
            'suministros_sin_stock' => Suministro::where('stock', 0)->count(),
            'suministros_bajo_stock' => Suministro::where('stock', '>', 0)->where('stock', '<=', 5)->count(),
        ];

        return view('dashboard', compact('estadisticas'));
    }
}
