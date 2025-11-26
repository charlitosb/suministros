@extends('layouts.app')

@section('title', 'Nuevo Ingreso - Sistema de Suministros')

@section('content')
<div class="page-title">Nuevo Ingreso de Suministro</div>

<div class="card" style="max-width: 700px;">
    <div class="alert alert-info">
        <strong>Nota:</strong> Al registrar un ingreso, se incrementará automáticamente el stock del suministro seleccionado.
    </div>

    <form action="{{ route('ingresos.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="id_suministro">Suministro *</label>
            <select id="id_suministro" name="id_suministro" class="form-control" required>
                <option value="">-- Seleccione un suministro --</option>
                @foreach($suministros as $suministro)
                    <option value="{{ $suministro->id }}" 
                            data-stock="{{ $suministro->stock }}"
                            {{ (old('id_suministro') == $suministro->id || request('suministro') == $suministro->id) ? 'selected' : '' }}>
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
                   value="{{ old('fecha_ingreso', date('Y-m-d')) }}"
                   required>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad a Ingresar *</label>
            <input type="number" 
                   id="cantidad" 
                   name="cantidad" 
                   class="form-control" 
                   value="{{ old('cantidad', 1) }}"
                   min="1"
                   placeholder="Cantidad"
                   required>
        </div>

        <div id="stock-preview" class="alert alert-warning" style="display: none;">
            <strong>Vista Previa:</strong>
            <span id="stock-message"></span>
        </div>

        <div class="btn-group" style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-success">Registrar Ingreso</button>
            <a href="{{ route('ingresos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const suministroSelect = document.getElementById('id_suministro');
    const cantidadInput = document.getElementById('cantidad');
    const stockPreview = document.getElementById('stock-preview');
    const stockMessage = document.getElementById('stock-message');

    function updatePreview() {
        const selectedOption = suministroSelect.options[suministroSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const stockActual = parseInt(selectedOption.dataset.stock) || 0;
            const cantidad = parseInt(cantidadInput.value) || 0;
            const nuevoStock = stockActual + cantidad;
            
            stockMessage.textContent = `Stock actual: ${stockActual} → Nuevo stock: ${nuevoStock} (+${cantidad})`;
            stockPreview.style.display = 'block';
        } else {
            stockPreview.style.display = 'none';
        }
    }

    suministroSelect.addEventListener('change', updatePreview);
    cantidadInput.addEventListener('input', updatePreview);

    // Inicializar si hay valor preseleccionado
    if (suministroSelect.value) {
        updatePreview();
    }
</script>
@endpush
