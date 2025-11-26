@extends('layouts.app')

@section('title', 'Nuevo Equipo - Sistema de Suministros')

@section('content')
<div class="page-title">Nuevo Equipo</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('equipos.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="numero_serie">Número de Serie *</label>
            <input type="text" 
                   id="numero_serie" 
                   name="numero_serie" 
                   class="form-control" 
                   value="{{ old('numero_serie') }}"
                   placeholder="Ej: LAP-HP-2024-001"
                   required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción *</label>
            <input type="text" 
                   id="descripcion" 
                   name="descripcion" 
                   class="form-control" 
                   value="{{ old('descripcion') }}"
                   placeholder="Ej: Laptop HP ProBook 450 G8"
                   required>
        </div>

        <div class="form-group">
            <label for="id_tipo">Tipo de Equipo *</label>
            <select id="id_tipo" name="id_tipo" class="form-control" required>
                <option value="">-- Seleccione un tipo --</option>
                @foreach($tiposEquipo as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('id_tipo') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->descripcion }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="btn-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
