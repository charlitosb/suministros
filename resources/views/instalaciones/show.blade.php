@extends('layouts.app')

@section('title', 'Detalle Instalación - Sistema de Suministros')

@section('content')
<div class="page-title">Detalle de Instalación</div>

<div class="card" style="max-width: 900px;">
    <div class="alert alert-info">
        <strong>✓ Instalación Registrada</strong><br>
        Se instaló 1 unidad del suministro en el equipo seleccionado.
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Información de la Instalación -->
        <div>
            <h4 style="color: #2c3e50; margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">
                Datos de la Instalación
            </h4>
            <div class="detail-row">
                <span class="detail-label">ID Instalación:</span>
                <span class="detail-value">{{ $instalacione->id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Fecha de Instalación:</span>
                <span class="detail-value"><strong>{{ $instalacione->fecha_instalacion->format('d/m/Y') }}</strong></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Registrado:</span>
                <span class="detail-value">{{ $instalacione->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <!-- Información del Equipo -->
        <div>
            <h4 style="color: #2c3e50; margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">
                Equipo Destino
            </h4>
            <div class="detail-row">
                <span class="detail-label">Número de Serie:</span>
                <span class="detail-value">
                    <strong>
                        <a href="{{ route('equipos.show', $instalacione->equipo) }}">
                            {{ $instalacione->equipo->numero_serie }}
                        </a>
                    </strong>
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Descripción:</span>
                <span class="detail-value">{{ $instalacione->equipo->descripcion }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tipo de Equipo:</span>
                <span class="detail-value">
                    <span class="badge badge-info">{{ $instalacione->equipo->tipoEquipo->descripcion }}</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Información del Suministro -->
    <div style="margin-top: 2rem;">
        <h4 style="color: #2c3e50; margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">
            Suministro Instalado
        </h4>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <div class="detail-row">
                    <span class="detail-label">Suministro:</span>
                    <span class="detail-value">
                        <a href="{{ route('suministros.show', $instalacione->suministro) }}">
                            {{ $instalacione->suministro->descripcion }}
                        </a>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Marca:</span>
                    <span class="detail-value">{{ $instalacione->suministro->marca->descripcion }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Categoría:</span>
                    <span class="detail-value">
                        <span class="badge badge-info">{{ $instalacione->suministro->categoria->nombre_categoria }}</span>
                    </span>
                </div>
            </div>
            <div>
                <div class="detail-row">
                    <span class="detail-label">Tipo de Equipo:</span>
                    <span class="detail-value">{{ $instalacione->suministro->tipoEquipo->descripcion }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Precio Unitario:</span>
                    <span class="detail-value">Q {{ number_format($instalacione->suministro->precio, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Stock Actual:</span>
                    <span class="detail-value">
                        @php $stock = $instalacione->suministro->stock; @endphp
                        @if($stock == 0)
                            <span class="badge badge-danger" style="font-size: 1rem;">{{ $stock }} - SIN STOCK</span>
                        @elseif($stock <= 5)
                            <span class="badge badge-warning" style="font-size: 1rem;">{{ $stock }} - BAJO</span>
                        @else
                            <span class="badge badge-success" style="font-size: 1rem;">{{ $stock }}</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="btn-group" style="margin-top: 2rem;">
        <a href="{{ route('instalaciones.create') }}" class="btn btn-warning">+ Nueva Instalación</a>
        <a href="{{ route('instalaciones.edit', $instalacione) }}" class="btn btn-primary">Editar</a>
        <a href="{{ route('equipos.show', $instalacione->equipo) }}" class="btn btn-info">Ver Equipo</a>
        <a href="{{ route('suministros.show', $instalacione->suministro) }}" class="btn btn-info">Ver Suministro</a>
        <a href="{{ route('instalaciones.index') }}" class="btn btn-secondary">Volver al Listado</a>
    </div>
</div>
@endsection
