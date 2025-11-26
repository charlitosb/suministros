@extends('layouts.app')

@section('title', 'Editar Tipo de Equipo - Sistema de Suministros')

@section('content')
<div class="page-title">Editar Tipo de Equipo</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('tipos-equipo.update', $tipos_equipo) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="descripcion">Descripción *</label>
            <input type="text" 
                   id="descripcion" 
                   name="descripcion" 
                   class="form-control" 
                   value="{{ old('descripcion', $tipos_equipo->descripcion) }}"
                   required>
        </div>

        <div class="btn-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('tipos-equipo.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
