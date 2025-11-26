@extends('layouts.app')

@section('title', 'Detalle Suministro - Sistema de Suministros')

@section('content')
<div class="page-title">Detalle de Suministro</div>

<div class="card" style="max-width: 900px;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
        <div>
            <div class="detail-row">
                <span class="detail-label">ID:</span>
                <span class="detail-value">{{ $suministro->id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Descripción:</span>
                <span class="detail-value"><strong>{{ $suministro->descripcion }}</strong></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Precio:</span>
                <span class="detail-value">Q {{ number_format($suministro->precio, 2) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Marca:</span>
                <span class="detail-value">{{ $suministro->marca->descripcion }}</span>
            </div>
        </div>
        <div>
            <div class="detail-row">
                <span class="detail-label">Categoría:</span>
                <span class="detail-value">
                    <span class="badge badge-info">{{ $suministro->categoria->nombre_categoria }}</span>
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tipo de Equipo:</span>
                <span class="detail-value">{{ $suministro->tipoEquipo->descripcion }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Stock Actual:</span>
                <span class="detail-value">
                    @if($suministro->stock == 0)
                        <span class="badge badge-danger">{{ $suministro->stock }} - SIN STOCK</span>
                    @elseif($suministro->stock <= 5)
                        <span class="badge badge-warning">{{ $suministro->stock }} - BAJO</span>
                    @else
                        <span class="badge badge-success">{{ $suministro->stock }}</span>
                    @endif
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Valor en Inventario:</span>
                <span class="detail-value">Q {{ number_format($suministro->precio * $suministro->stock, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="btn-group" style="margin-top: 1.5rem; margin-bottom: 1.5rem;">
        <a href="{{ route('ingresos.create') }}?suministro={{ $suministro->id }}" class="btn btn-success">+ Agregar Stock</a>
        @if($suministro->stock > 0)
        <a href="{{ route('instalaciones.create') }}?suministro={{ $suministro->id }}" class="btn btn-warning">Instalar</a>
        @endif
        <a href="{{ route('suministros.edit', $suministro) }}" class="btn btn-primary">Editar</a>
        <a href="{{ route('suministros.index') }}" class="btn btn-secondary">Volver</a>
    </div>

    @if($suministro->ingresos->count() > 0)
    <div style="margin-top: 1rem;">
        <h4 style="color: #2c3e50; margin-bottom: 1rem;">Últimos Ingresos</h4>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th style="text-align: center;">Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suministro->ingresos->sortByDesc('fecha_ingreso')->take(5) as $ingreso)
                <tr>
                    <td>{{ $ingreso->fecha_ingreso->format('d/m/Y') }}</td>
                    <td style="text-align: center;" class="text-success">+{{ $ingreso->cantidad }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($suministro->instalaciones->count() > 0)
    <div style="margin-top: 1.5rem;">
        <h4 style="color: #2c3e50; margin-bottom: 1rem;">Últimas Instalaciones</h4>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Equipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suministro->instalaciones->sortByDesc('fecha_instalacion')->take(5) as $instalacion)
                <tr>
                    <td>{{ $instalacion->fecha_instalacion->format('d/m/Y') }}</td>
                    <td>{{ $instalacion->equipo->numero_serie }} - {{ $instalacion->equipo->descripcion }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
