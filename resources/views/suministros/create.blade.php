@extends('layouts.app')

@section('title', 'Nuevo Suministro - Sistema de Suministros')

@section('content')
<div class="page-title">Nuevo Suministro</div>

<div class="card" style="max-width: 700px;">
    <div class="alert alert-info">
        <strong>Nota:</strong> El stock inicial será 0. Para agregar stock, debe realizar un <a href="{{ route('ingresos.create') }}">Ingreso de Suministro</a>.
    </div>

    <form action="{{ route('suministros.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="descripcion">Descripción *</label>
            <input type="text" 
                   id="descripcion" 
                   name="descripcion" 
                   class="form-control" 
                   value="{{ old('descripcion') }}"
                   placeholder="Ej: Toner HP 107A Negro"
                   required>
        </div>

        <div class="form-group">
            <label for="precio">Precio (Q) *</label>
            <input type="number" 
                   id="precio" 
                   name="precio" 
                   class="form-control" 
                   value="{{ old('precio', '0.00') }}"
                   step="0.01"
                   min="0"
                   placeholder="0.00"
                   required>
        </div>

        <div class="form-group">
            <label for="id_marca">Marca *</label>
            <select id="id_marca" name="id_marca" class="form-control" required>
                <option value="">-- Seleccione una marca --</option>
                @foreach($marcas as $marca)
                    <option value="{{ $marca->id }}" {{ old('id_marca') == $marca->id ? 'selected' : '' }}>
                        {{ $marca->descripcion }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="id_categoria">Categoría *</label>
            <select id="id_categoria" name="id_categoria" class="form-control" required>
                <option value="">-- Seleccione una categoría --</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('id_categoria') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre_categoria }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="id_tipo_equipo">Tipo de Equipo *</label>
            <select id="id_tipo_equipo" name="id_tipo_equipo" class="form-control" required>
                <option value="">-- Seleccione un tipo de equipo --</option>
                @foreach($tiposEquipo as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('id_tipo_equipo') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->descripcion }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="btn-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{ route('suministros.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
