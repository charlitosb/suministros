@extends('layouts.app')

@section('title', 'Detalle Categoría - Sistema de Suministros')

@section('content')
<div class="page-title">Detalle de Categoría</div>

<div class="card" style="max-width: 600px;">
    <div class="detail-row">
        <span class="detail-label">ID:</span>
        <span class="detail-value">{{ $categoria->id }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Nombre de Categoría:</span>
        <span class="detail-value">{{ $categoria->nombre_categoria }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Fecha Creación:</span>
        <span class="detail-value">{{ $categoria->created_at->format('d/m/Y H:i') }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Última Actualización:</span>
        <span class="detail-value">{{ $categoria->updated_at->format('d/m/Y H:i') }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-label">Suministros Asociados:</span>
        <span class="detail-value">{{ $categoria->suministros->count() }}</span>
    </div>

    <div class="btn-group" style="margin-top: 1.5rem;">
        <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
