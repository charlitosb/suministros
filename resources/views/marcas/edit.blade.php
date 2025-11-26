@extends('layouts.app')

@section('title', 'Editar Marca - Sistema de Suministros')

@section('content')
<div class="page-title">Editar Marca</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('marcas.update', $marca) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="descripcion">Descripción *</label>
            <input type="text" 
                   id="descripcion" 
                   name="descripcion" 
                   class="form-control" 
                   value="{{ old('descripcion', $marca->descripcion) }}"
                   required>
        </div>

        <div class="btn-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('marcas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
