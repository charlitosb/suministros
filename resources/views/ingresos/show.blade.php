@extends('layouts.app')

@section('title', 'Detalle Ingreso - Sistema de Suministros')

@section('content')
<div class="page-title">Detalle de Ingreso</div>

<div class="card" style="max-width: 800px;">
    <div class="alert alert-success">
        <strong>✓ Ingreso Registrado</strong><br>
        Se agregaron <strong>{{ $ingreso->cantidad }}</strong> unidades al stock del suministro.
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Información del Ingreso -->
        <div>
            <h4 style="color: #2c3e50; margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">
                Datos del Ingreso
            </h4>
            <div class="detail-row">
                <span class="detail-label">ID Ingreso:</span>
                <span class="detail-value">{{ $ingreso->id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Fecha de Ingreso:</span>
                <span class="detail-value"><strong>{{ $ingreso->fecha_ingreso->format('d/m/Y') }}</strong></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Cantidad Ingresada:</span>
                <span class="detail-value">
                    <span class="badge badge-success" style="font-size: 1rem;">+{{ $ingreso->cantidad }}</span>
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Registrado:</span>
                <span class="detail-value">{{ $ingreso->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <!-- Información del Suministro -->
        <div>
            <h4 style="color: #2c3e50; margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">
                Suministro Afectado
            </h4>
            <div class="detail-row">
                <span class="detail-label">Suministro:</span>
                <span class="detail-value">
                    <a href="{{ route('suministros.show', $ingreso->suministro) }}">
                        {{ $ingreso->suministro->descripcion }}
                    </a>
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Marca:</span>
                <span class="detail-value">{{ $ingreso->suministro->marca->descripcion }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Categoría:</span>
                <span class="detail-value">
                    <span class="badge badge-info">{{ $ingreso->suministro->categoria->nombre_categoria }}</span>
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Stock Actual:</span>
                <span class="detail-value">
                    @if($stockActual == 0)
                        <span class="badge badge-danger" style="font-size: 1rem;">{{ $stockActual }}</span>
                    @elseif($stockActual <= 5)
                        <span class="badge badge-warning" style="font-size: 1rem;">{{ $stockActual }}</span>
                    @else
                        <span class="badge badge-success" style="font-size: 1rem;">{{ $stockActual }}</span>
                    @endif
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Precio Unitario:</span>
                <span class="detail-value">Q {{ number_format($ingreso->suministro->precio, 2) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Valor Ingresado:</span>
                <span class="detail-value"><strong>Q {{ number_format($ingreso->suministro->precio * $ingreso->cantidad, 2) }}</strong></span>
            </div>
        </div>
    </div>

    <div class="btn-group" style="margin-top: 2rem;">
        <a href="{{ route('ingresos.create') }}" class="btn btn-success">+ Nuevo Ingreso</a>
        <a href="{{ route('ingresos.edit', $ingreso) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('suministros.show', $ingreso->suministro) }}" class="btn btn-primary">Ver Suministro</a>
        <a href="{{ route('ingresos.index') }}" class="btn btn-secondary">Volver al Listado</a>
    </div>
</div>
@endsection
