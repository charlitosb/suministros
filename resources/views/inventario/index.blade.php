@extends('layouts.app')

@section('title', 'Inventario - Sistema de Suministros')

@section('content')
<div class="page-title">Inventario de Suministros</div>

<!-- Estadísticas -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $estadisticas['total'] }}</div>
        <div class="stat-label">Total Productos</div>
    </div>
    <div class="stat-card success">
        <div class="stat-value">{{ $estadisticas['con_stock'] }}</div>
        <div class="stat-label">Con Stock</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-value">{{ $estadisticas['bajo_stock'] }}</div>
        <div class="stat-label">Stock Bajo</div>
    </div>
    <div class="stat-card danger">
        <div class="stat-value">{{ $estadisticas['sin_stock'] }}</div>
        <div class="stat-label">Sin Stock</div>
    </div>
    <div class="stat-card info">
        <div class="stat-value">Q {{ number_format($estadisticas['valor_total'], 2) }}</div>
        <div class="stat-label">Valor Total</div>
    </div>
</div>

<!-- Filtros -->
<div class="card">
    <form action="{{ route('inventario.index') }}" method="GET">
        <div class="filters">
            <div class="form-group">
                <label for="buscar">Buscar</label>
                <input type="text" 
                       id="buscar" 
                       name="buscar" 
                       class="form-control" 
                       value="{{ request('buscar') }}"
                       placeholder="Descripción o marca...">
            </div>

            <div class="form-group">
                <label for="categoria_id">Categoría</label>
                <select id="categoria_id" name="categoria_id" class="form-control">
                    <option value="">Todas</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre_categoria }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="marca_id">Marca</label>
                <select id="marca_id" name="marca_id" class="form-control">
                    <option value="">Todas</option>
                    @foreach($marcas as $marca)
                        <option value="{{ $marca->id }}" {{ request('marca_id') == $marca->id ? 'selected' : '' }}>
                            {{ $marca->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tipo_equipo_id">Tipo Equipo</label>
                <select id="tipo_equipo_id" name="tipo_equipo_id" class="form-control">
                    <option value="">Todos</option>
                    @foreach($tiposEquipo as $tipo)
                        <option value="{{ $tipo->id }}" {{ request('tipo_equipo_id') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="estado_stock">Estado Stock</label>
                <select id="estado_stock" name="estado_stock" class="form-control">
                    <option value="">Todos</option>
                    <option value="sin_stock" {{ request('estado_stock') == 'sin_stock' ? 'selected' : '' }}>Sin Stock</option>
                    <option value="bajo_stock" {{ request('estado_stock') == 'bajo_stock' ? 'selected' : '' }}>Stock Bajo (≤5)</option>
                    <option value="con_stock" {{ request('estado_stock') == 'con_stock' ? 'selected' : '' }}>Con Stock (>5)</option>
                </select>
            </div>

            <div class="form-group">
                <label>&nbsp;</label>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="{{ route('inventario.index') }}" class="btn btn-secondary">Limpiar</a>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Tabla de Inventario -->
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <div class="card-header" style="border: none; margin: 0; padding: 0;">
            Listado de Inventario ({{ $suministros->total() }} registros)
        </div>
        <a href="{{ route('inventario.pdf', request()->query()) }}" class="btn btn-danger" target="_blank">
            📄 Exportar PDF
        </a>
    </div>

    @if($suministros->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>
                            <a href="{{ route('inventario.index', array_merge(request()->query(), ['ordenar_por' => 'descripcion', 'ordenar_dir' => request('ordenar_dir') == 'asc' && request('ordenar_por') == 'descripcion' ? 'desc' : 'asc'])) }}" style="color: inherit; text-decoration: none;">
                                Descripción {{ request('ordenar_por') == 'descripcion' ? (request('ordenar_dir') == 'asc' ? '↑' : '↓') : '' }}
                            </a>
                        </th>
                        <th>Marca</th>
                        <th>Categoría</th>
                        <th>Tipo Equipo</th>
                        <th style="text-align: right;">
                            <a href="{{ route('inventario.index', array_merge(request()->query(), ['ordenar_por' => 'precio', 'ordenar_dir' => request('ordenar_dir') == 'asc' && request('ordenar_por') == 'precio' ? 'desc' : 'asc'])) }}" style="color: inherit; text-decoration: none;">
                                Precio {{ request('ordenar_por') == 'precio' ? (request('ordenar_dir') == 'asc' ? '↑' : '↓') : '' }}
                            </a>
                        </th>
                        <th style="text-align: center;">
                            <a href="{{ route('inventario.index', array_merge(request()->query(), ['ordenar_por' => 'stock', 'ordenar_dir' => request('ordenar_dir') == 'asc' && request('ordenar_por') == 'stock' ? 'desc' : 'asc'])) }}" style="color: inherit; text-decoration: none;">
                                Stock {{ request('ordenar_por') == 'stock' ? (request('ordenar_dir') == 'asc' ? '↑' : '↓') : '' }}
                            </a>
                        </th>
                        <th style="text-align: right;">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suministros as $suministro)
                    <tr>
                        <td>
                            <a href="{{ route('suministros.show', $suministro) }}" style="color: #2c3e50; text-decoration: none;">
                                {{ $suministro->descripcion }}
                            </a>
                        </td>
                        <td>{{ $suministro->marca->descripcion }}</td>
                        <td>
                            <span class="badge badge-info">{{ $suministro->categoria->nombre_categoria }}</span>
                        </td>
                        <td>{{ $suministro->tipoEquipo->descripcion }}</td>
                        <td style="text-align: right;">Q {{ number_format($suministro->precio, 2) }}</td>
                        <td style="text-align: center;">
                            @if($suministro->stock == 0)
                                <span class="badge badge-danger">{{ $suministro->stock }}</span>
                            @elseif($suministro->stock <= 5)
                                <span class="badge badge-warning">{{ $suministro->stock }}</span>
                            @else
                                <span class="badge badge-success">{{ $suministro->stock }}</span>
                            @endif
                        </td>
                        <td style="text-align: right;">Q {{ number_format($suministro->precio * $suministro->stock, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $suministros->links() }}
        </div>
    @else
        <p class="text-muted">No se encontraron suministros con los filtros seleccionados.</p>
    @endif
</div>
@endsection
