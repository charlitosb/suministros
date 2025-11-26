@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Suministros')

@section('content')
<div class="card" style="text-align: center; padding: 3rem;">
    <h2 style="color: #2c3e50; font-size: 2rem; margin-bottom: 1rem;">
        ¡Bienvenido al Sistema de Suministros!
    </h2>
    <p style="color: #7f8c8d; font-size: 1.1rem; margin-bottom: 2rem;">
        Gestión de inventario de suministros para equipos de cómputo
    </p>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $estadisticas['total_suministros'] }}</div>
            <div class="stat-label">Suministros</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $estadisticas['total_equipos'] }}</div>
            <div class="stat-label">Equipos</div>
        </div>
        <div class="stat-card success">
            <div class="stat-value">{{ $estadisticas['total_ingresos'] }}</div>
            <div class="stat-label">Ingresos</div>
        </div>
        <div class="stat-card info">
            <div class="stat-value">{{ $estadisticas['total_instalaciones'] }}</div>
            <div class="stat-label">Instalaciones</div>
        </div>
    </div>

    <div class="stats-grid" style="margin-top: 1rem;">
        <div class="stat-card danger">
            <div class="stat-value">{{ $estadisticas['suministros_sin_stock'] }}</div>
            <div class="stat-label">Sin Stock</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-value">{{ $estadisticas['suministros_bajo_stock'] }}</div>
            <div class="stat-label">Stock Bajo (≤5)</div>
        </div>
    </div>

    <div style="margin-top: 2rem;">
        <a href="{{ route('inventario.index') }}" class="btn btn-primary" style="margin-right: 0.5rem;">
            Ver Inventario
        </a>
        <a href="{{ route('ingresos.create') }}" class="btn btn-success" style="margin-right: 0.5rem;">
            Nuevo Ingreso
        </a>
        <a href="{{ route('instalaciones.create') }}" class="btn btn-warning">
            Nueva Instalación
        </a>
    </div>
</div>
@endsection
