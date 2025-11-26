@extends('layouts.app')

@section('title', 'Suministros - Sistema de Suministros')

@section('content')
<div class="page-title">Suministros</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <div class="card-header" style="border: none; margin: 0; padding: 0;">
            Listado de Suministros
        </div>
        <a href="{{ route('suministros.create') }}" class="btn btn-primary">
            + Nuevo Suministro
        </a>
    </div>

    @if($suministros->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Marca</th>
                        <th>Categoría</th>
                        <th>Tipo Equipo</th>
                        <th style="text-align: right;">Precio</th>
                        <th style="text-align: center;">Stock</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suministros as $suministro)
                    <tr>
                        <td>{{ $suministro->id }}</td>
                        <td>{{ $suministro->descripcion }}</td>
                        <td>{{ $suministro->marca->descripcion }}</td>
                        <td>
                            <span class="badge badge-info">{{ $suministro->categoria->nombre_categoria }}</span>
                        </td>
                        <td>{{ $suministro->tipoEquipo->descripcion }}</td>
                        <td style="text-align: right;">Q {{ number_format($suministro->precio, 2) }}</td>
                        <td style="text-align: center;">
                            @if($suministro->stock == 0)
                                <span class="stock-out">{{ $suministro->stock }}</span>
                            @elseif($suministro->stock <= 5)
                                <span class="stock-low">{{ $suministro->stock }}</span>
                            @else
                                <span class="stock-ok">{{ $suministro->stock }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" style="justify-content: center;">
                                <a href="{{ route('suministros.show', $suministro) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('suministros.edit', $suministro) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('suministros.destroy', $suministro) }}" method="POST" style="display: inline;"
                                      onsubmit="return confirm('¿Está seguro de eliminar este suministro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $suministros->links() }}
        </div>
    @else
        <p class="text-muted">No hay suministros registrados.</p>
    @endif
</div>
@endsection
