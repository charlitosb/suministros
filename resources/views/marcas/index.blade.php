@extends('layouts.app')

@section('title', 'Marcas - Sistema de Suministros')

@section('content')
<div class="page-title">Marcas</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <div class="card-header" style="border: none; margin: 0; padding: 0;">
            Listado de Marcas
        </div>
        <a href="{{ route('marcas.create') }}" class="btn btn-primary">
            + Nueva Marca
        </a>
    </div>

    @if($marcas->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Fecha Creación</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($marcas as $marca)
                    <tr>
                        <td>{{ $marca->id }}</td>
                        <td>{{ $marca->descripcion }}</td>
                        <td>{{ $marca->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" style="justify-content: center;">
                                <a href="{{ route('marcas.show', $marca) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('marcas.edit', $marca) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('marcas.destroy', $marca) }}" method="POST" style="display: inline;" 
                                      onsubmit="return confirm('¿Está seguro de eliminar esta marca?')">
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
            {{ $marcas->links() }}
        </div>
    @else
        <p class="text-muted">No hay marcas registradas.</p>
    @endif
</div>
@endsection
