@extends('layouts.app')

@section('title', 'Editar Categoría - Sistema de Suministros')

@section('content')
<div class="page-title">Editar Categoría</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('categorias.update', $categoria) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="nombre_categoria">Nombre de Categoría *</label>
            <input type="text" 
                   id="nombre_categoria" 
                   name="nombre_categoria" 
                   class="form-control" 
                   value="{{ old('nombre_categoria', $categoria->nombre_categoria) }}"
                   required>
        </div>

        <div class="btn-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
