@extends('layouts.app')

@section('title', 'Detalle Equipo - Sistema de Suministros')

@section('content')
<div class="page-title">Detalle de Equipo</div>

<div class="card" style="max-width: 800px;">
    <div class="detail-row">
        <span class="detail-label">ID:</span>
        <span class="detail-value">{{ $equipo->id }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Número de Serie:</span>
        <span class="detail-value"><strong>{{ $equipo->numero_serie }}</strong></span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Descripción:</span>
        <span class="detail-value">{{ $equipo->descripcion }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Tipo de Equipo:</span>
        <span class="detail-value">
            <span class="badge badge-info">{{ $equipo->tipoEquipo->descripcion }}</span>
        </span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Fecha Creación:</span>
        <span class="detail-value">{{ $equipo->created_at->format('d/m/Y H:i') }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Instalaciones:</span>
        <span class="detail-value">{{ $equipo->instalaciones->count() }}</span>
    </div>

    @if($equipo->instalaciones->count() > 0)
    <div style="margin-top: 1.5rem;">
        <h4 style="color: #2c3e50; margin-bottom: 1rem;">Historial de Instalaciones</h4>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Suministro</th>
                </tr>
            </thead>
            <tbody>
                @foreach($equipo->instalaciones->sortByDesc('fecha_instalacion')->take(10) as $instalacion)
                <tr>
                    <td>{{ $instalacion->fecha_instalacion->format('d/m/Y') }}</td>
                    <td>{{ $instalacion->suministro->descripcion }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="btn-group" style="margin-top: 1.5rem;">
        <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
