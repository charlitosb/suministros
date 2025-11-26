@extends('layouts.app')

@section('title', 'Editar Ingreso - Sistema de Suministros')

@section('content')
<div class="page-title">Editar Ingreso de Suministro</div>

<div class="card" style="max-width: 700px;">
    <div class="alert alert-warning">
        <strong>Advertencia:</strong> Modificar este ingreso puede afectar el stock del suministro.
    </div>

    <form action="{{ route('ingresos.update', $ingreso) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="id_suministro">Suministro *</label>
            <select id="id_suministro" name="id_suministro" class="form-control" required>
                <option value="">-- Seleccione un suministro --</option>
                @foreach($suministros as $suministro)
                    <option value="{{ $suministro->id }}" 
                            {{ old('id_suministro', $ingreso->id_suministro) == $suministro->id ? 'selected' : '' }}>
                        {{ $suministro->descripcion }} ({{ $suministro->marca->descripcion }}) - Stock: {{ $suministro->stock }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="fecha_ingreso">Fecha de Ingreso *</label>
            <input type="date" 
                   id="fecha_ingreso" 
                   name="fecha_ingreso" 
                   class="form-control" 
                   value="{{ old('fecha_ingreso', $ingreso->fecha_ingreso->format('Y-m-d')) }}"
                   required>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad *</label>
            <input type="number" 
                   id="cantidad" 
                   name="cantidad" 
                   class="form-control" 
                   value="{{ old('cantidad', $ingreso->cantidad) }}"
                   min="1"
                   required>
            <small class="text-muted">Cantidad original: {{ $ingreso->cantidad }}</small>
        </div>

        <div class="btn-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('ingresos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
