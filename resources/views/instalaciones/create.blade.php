@extends('layouts.app')

@section('title', 'Nueva Instalación - Sistema de Suministros')

@section('content')
<div class="page-title">Nueva Instalación de Suministro</div>

<div class="card" style="max-width: 800px;">
    @if($sinStock)
        <div class="alert alert-danger">
            <strong>⚠ Sin Stock Disponible</strong><br>
            No hay suministros con stock disponible para instalar. 
            <a href="{{ route('ingresos.create') }}">Registre un ingreso</a> primero.
        </div>
    @else
        <div class="alert alert-warning">
            <strong>Importante:</strong> Al registrar una instalación, se reducirá <strong>1 unidad</strong> del stock del suministro seleccionado.
            Solo se muestran suministros con stock disponible.
        </div>

        <form action="{{ route('instalaciones.store') }}" method="POST" id="instalacionForm">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <div class="form-group">
                        <label for="id_suministro">Suministro a Instalar *</label>
                        <select id="id_suministro" name="id_suministro" class="form-control" required>
                            <option value="">-- Seleccione un suministro --</option>
                            @foreach($suministros as $suministro)
                                <option value="{{ $suministro->id }}" 
                                        data-stock="{{ $suministro->stock }}"
                                        data-descripcion="{{ $suministro->descripcion }}"
                                        data-marca="{{ $suministro->marca->descripcion }}"
                                        data-categoria="{{ $suministro->categoria->nombre_categoria }}"
                                        {{ (old('id_suministro') == $suministro->id || request('suministro') == $suministro->id) ? 'selected' : '' }}>
                                    {{ $suministro->descripcion }} ({{ $suministro->marca->descripcion }}) - Stock: {{ $suministro->stock }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_equipo">Equipo Destino *</label>
                        <select id="id_equipo" name="id_equipo" class="form-control" required>
                            <option value="">-- Seleccione un equipo --</option>
                            @foreach($equipos as $equipo)
                                <option value="{{ $equipo->id }}" {{ old('id_equipo') == $equipo->id ? 'selected' : '' }}>
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
                               value="{{ old('fecha_instalacion', date('Y-m-d')) }}"
                               required>
                    </div>
                </div>

                <div>
                    <!-- Panel de información del suministro seleccionado -->
                    <div id="suministro-info" class="card" style="background-color: #f8f9fa; display: none;">
                        <h4 style="color: #2c3e50; margin-bottom: 1rem;">Información del Suministro</h4>
                        <div class="detail-row">
                            <span class="detail-label">Producto:</span>
                            <span class="detail-value" id="info-descripcion">-</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Marca:</span>
                            <span class="detail-value" id="info-marca">-</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Categoría:</span>
                            <span class="detail-value" id="info-categoria">-</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Stock Actual:</span>
                            <span class="detail-value">
                                <span id="info-stock-badge" class="badge">-</span>
                            </span>
                        </div>
                        <div class="detail-row" style="margin-top: 1rem; padding-top: 1rem; border-top: 2px solid #ddd;">
                            <span class="detail-label">Stock después de instalación:</span>
                            <span class="detail-value">
                                <span id="info-nuevo-stock" class="badge badge-warning" style="font-size: 1rem;">-</span>
                            </span>
                        </div>
                    </div>

                    <div id="sin-seleccion" class="card" style="background-color: #f8f9fa; text-align: center; padding: 2rem;">
                        <p class="text-muted">Seleccione un suministro para ver su información</p>
                    </div>
                </div>
            </div>

            <div class="btn-group" style="margin-top: 1.5rem;">
                <button type="submit" class="btn btn-success" id="btn-submit">
                    Registrar Instalación
                </button>
                <a href="{{ route('instalaciones.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    @endif
</div>
@endsection

@push('scripts')
<script>
    const suministroSelect = document.getElementById('id_suministro');
    const suministroInfo = document.getElementById('suministro-info');
    const sinSeleccion = document.getElementById('sin-seleccion');
    const btnSubmit = document.getElementById('btn-submit');

    function updateSuministroInfo() {
        const selectedOption = suministroSelect.options[suministroSelect.selectedIndex];
        
        if (selectedOption && selectedOption.value) {
            const stock = parseInt(selectedOption.dataset.stock) || 0;
            const descripcion = selectedOption.dataset.descripcion;
            const marca = selectedOption.dataset.marca;
            const categoria = selectedOption.dataset.categoria;
            const nuevoStock = stock - 1;

            document.getElementById('info-descripcion').textContent = descripcion;
            document.getElementById('info-marca').textContent = marca;
            document.getElementById('info-categoria').textContent = categoria;
            
            const stockBadge = document.getElementById('info-stock-badge');
            stockBadge.textContent = stock;
            stockBadge.className = 'badge ' + (stock <= 5 ? (stock == 0 ? 'badge-danger' : 'badge-warning') : 'badge-success');
            
            const nuevoStockBadge = document.getElementById('info-nuevo-stock');
            nuevoStockBadge.textContent = nuevoStock;
            nuevoStockBadge.className = 'badge ' + (nuevoStock <= 5 ? (nuevoStock == 0 ? 'badge-danger' : 'badge-warning') : 'badge-success');
            nuevoStockBadge.style.fontSize = '1rem';

            suministroInfo.style.display = 'block';
            sinSeleccion.style.display = 'none';

            // Validar que hay stock
            if (stock < 1) {
                btnSubmit.disabled = true;
                btnSubmit.textContent = 'Sin Stock Disponible';
                btnSubmit.className = 'btn btn-danger';
            } else {
                btnSubmit.disabled = false;
                btnSubmit.textContent = 'Registrar Instalación';
                btnSubmit.className = 'btn btn-success';
            }
        } else {
            suministroInfo.style.display = 'none';
            sinSeleccion.style.display = 'block';
            btnSubmit.disabled = false;
            btnSubmit.textContent = 'Registrar Instalación';
            btnSubmit.className = 'btn btn-success';
        }
    }

    suministroSelect.addEventListener('change', updateSuministroInfo);

    // Inicializar si hay valor preseleccionado
    if (suministroSelect.value) {
        updateSuministroInfo();
    }

    // Validación antes de enviar
    document.getElementById('instalacionForm')?.addEventListener('submit', function(e) {
        const selectedOption = suministroSelect.options[suministroSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const stock = parseInt(selectedOption.dataset.stock) || 0;
            if (stock < 1) {
                e.preventDefault();
                alert('Error: El suministro seleccionado no tiene stock disponible.');
                return false;
            }
        }
    });
</script>
@endpush
