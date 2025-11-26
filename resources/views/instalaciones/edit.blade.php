@extends('layouts.app')

@section('title', 'Editar Instalación - Sistema de Suministros')

@section('content')
<div class="page-title">Editar Instalación</div>

<div class="card" style="max-width: 700px;">
    <div class="alert alert-warning">
        <strong>Advertencia:</strong> Cambiar el suministro afectará el stock de ambos suministros (el anterior y el nuevo).
    </div>

    <form action="{{ route('instalaciones.update', $instalacione) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="id_suministro">Suministro *</label>
            <select id="id_suministro" name="id_suministro" class="form-control" required>
                <option value="">-- Seleccione un suministro --</option>
                @foreach($suministros as $suministro)
                    <option value="{{ $suministro->id }}" 
                            data-stock="{{ $suministro->stock }}"
                            {{ old('id_suministro', $instalacione->id_suministro) == $suministro->id ? 'selected' : '' }}>
                        {{ $suministro->descripcion }} ({{ $suministro->marca->descripcion }}) - Stock: {{ $suministro->stock }}
                        @if($suministro->id == $instalacione->id_suministro) [ACTUAL] @endif
                    </option>
                @endforeach
            </select>
            <small class="text-muted">
                Suministro actual: {{ $instalacione->suministro->descripcion }}
            </small>
        </div>

        <div class="form-group">
            <label for="id_equipo">Equipo Destino *</label>
            <select id="id_equipo" name="id_equipo" class="form-control" required>
                <option value="">-- Seleccione un equipo --</option>
                @foreach($equipos as $equipo)
                    <option value="{{ $equipo->id }}" {{ old('id_equipo', $instalacione->id_equipo) == $equipo->id ? 'selected' : '' }}>
                        {{ $equipo->numero_serie }} - {{ $equipo->descripcion }} ({{ $equipo->tipoEquipo->descripcion }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="fecha_instalacion">Fecha de Instalación *</label>
            <input type="date" 
                   id="fecha_instalacion" 
                   name="fecha_instalacion" 
                   class="form-control" 
                   value="{{ old('fecha_instalacion', $instalacione->fecha_instalacion->format('Y-m-d')) }}"
                   required>
        </div>

        <div id="stock-warning" class="alert alert-danger" style="display: none;">
            <strong>⚠ Advertencia:</strong> El suministro seleccionado no tiene stock disponible.
        </div>

        <div class="btn-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-success" id="btn-submit">Actualizar</button>
            <a href="{{ route('instalaciones.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const suministroSelect = document.getElementById('id_suministro');
    const stockWarning = document.getElementById('stock-warning');
    const btnSubmit = document.getElementById('btn-submit');
    const suministroActualId = {{ $instalacione->id_suministro }};

    function checkStock() {
        const selectedOption = suministroSelect.options[suministroSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const stock = parseInt(selectedOption.dataset.stock) || 0;
            const esElMismo = parseInt(selectedOption.value) === suministroActualId;
            
            // Si es el mismo suministro, no hay problema
            // Si es diferente, necesita tener stock
            if (!esElMismo && stock < 1) {
                stockWarning.style.display = 'block';
                btnSubmit.disabled = true;
            } else {
                stockWarning.style.display = 'none';
                btnSubmit.disabled = false;
            }
        }
    }

    suministroSelect.addEventListener('change', checkStock);
    checkStock();
</script>
@endpush
