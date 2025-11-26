@extends('layouts.app')

@section('title', 'Editar Equipo - Sistema de Suministros')

@section('content')
<div class="page-title">Editar Equipo</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('equipos.update', $equipo) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="numero_serie">Número de Serie *</label>
            <input type="text" 
                   id="numero_serie" 
                   name="numero_serie" 
                   class="form-control" 
                   value="{{ old('numero_serie', $equipo->numero_serie) }}"
                   required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción *</label>
            <input type="text" 
                   id="descripcion" 
                   name="descripcion" 
                   class="form-control" 
                   value="{{ old('descripcion', $equipo->descripcion) }}"
                   required>
        </div>

        <div class="form-group">
            <label for="id_tipo">Tipo de Equipo *</label>
            <select id="id_tipo" name="id_tipo" class="form-control" required>
                <option value="">-- Seleccione un tipo --</option>
                @foreach($tiposEquipo as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('id_tipo', $equipo->id_tipo) == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->descripcion }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="btn-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
