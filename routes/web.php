<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TipoEquipoController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\SuministroController;
use App\Http\Controllers\IngresoSuministroController;
use App\Http\Controllers\InstalacionSuministroController;
use App\Http\Controllers\InventarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Ruta raíz redirige al login o dashboard
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// =====================================================
// RUTAS DE AUTENTICACIÓN (Públicas)
// =====================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================================================
// RUTAS PROTEGIDAS (Requieren autenticación)
// =====================================================
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // =====================================================
    // CRUD: Marcas
    // =====================================================
    Route::resource('marcas', MarcaController::class);

    // =====================================================
    // CRUD: Categorías
    // =====================================================
    Route::resource('categorias', CategoriaController::class);

    // =====================================================
    // CRUD: Tipos de Equipo
    // =====================================================
    Route::resource('tipos-equipo', TipoEquipoController::class);

    // =====================================================
    // CRUD: Equipos
    // =====================================================
    Route::resource('equipos', EquipoController::class);

    // =====================================================
    // CRUD: Suministros
    // =====================================================
    Route::resource('suministros', SuministroController::class);

    // =====================================================
    // CRUD: Ingresos de Suministros
    // =====================================================
    Route::resource('ingresos', IngresoSuministroController::class);

    // =====================================================
    // CRUD: Instalaciones de Suministros
    // =====================================================
    Route::resource('instalaciones', InstalacionSuministroController::class);
    
    // API para obtener stock (AJAX)
    Route::get('/api/suministros/{id}/stock', [InstalacionSuministroController::class, 'getStock'])
        ->name('api.suministros.stock');

    // =====================================================
    // Inventario
    // =====================================================
    Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('/inventario/pdf', [InventarioController::class, 'exportarPdf'])->name('inventario.pdf');
});
