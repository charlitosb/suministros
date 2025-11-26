@extends('layouts.app')

@section('title', 'Detalle Marca - Sistema de Suministros')

@section('content')
<div class="page-title">Detalle de Marca</div>

<div class="card" style="max-width: 600px;">
    <div class="detail-row">
        <span class="detail-label">ID:</span>
        <span class="detail-value">{{ $marca->id }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Descripción:</span>
        <span class="detail-value">{{ $marca->descripcion }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Fecha Creación:</span>
        <span class="detail-value">{{ $marca->created_at->format('d/m/Y H:i') }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Última Actualización:</span>
        <span class="detail-value">{{ $marca->updated_at->format('d/m/Y H:i') }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Suministros Asociados:</span>
        <span class="detail-value">{{ $marca->suministros->count() }}</span>
    </div>

    <div class="btn-group" style="margin-top: 1.5rem;">
        <a href="{{ route('marcas.edit', $marca) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('marcas.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
