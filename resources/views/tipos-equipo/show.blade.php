@extends('layouts.app')

@section('title', 'Detalle Tipo de Equipo - Sistema de Suministros')

@section('content')
<div class="page-title">Detalle de Tipo de Equipo</div>

<div class="card" style="max-width: 600px;">
    <div class="detail-row">
        <span class="detail-label">ID:</span>
        <span class="detail-value">{{ $tipos_equipo->id }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Descripción:</span>
        <span class="detail-value">{{ $tipos_equipo->descripcion }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Fecha Creación:</span>
        <span class="detail-value">{{ $tipos_equipo->created_at->format('d/m/Y H:i') }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Última Actualización:</span>
        <span class="detail-value">{{ $tipos_equipo->updated_at->format('d/m/Y H:i') }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Equipos Asociados:</span>
        <span class="detail-value">{{ $tipos_equipo->equipos->count() }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Suministros Asociados:</span>
        <span class="detail-value">{{ $tipos_equipo->suministros->count() }}</span>
    </div>

    <div class="btn-group" style="margin-top: 1.5rem;">
        <a href="{{ route('tipos-equipo.edit', $tipos_equipo) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('tipos-equipo.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
