@extends('layouts.app')

@section('title', 'Nueva Marca - Sistema de Suministros')

@section('content')
<div class="page-title">Nueva Marca</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('marcas.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="descripcion">Descripción *</label>
            <input type="text" 
                   id="descripcion" 
                   name="descripcion" 
                   class="form-control" 
                   value="{{ old('descripcion') }}"
                   placeholder="Ej: HP, Epson, Canon..."
                   required>
        </div>

        <div class="btn-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{ route('marcas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
