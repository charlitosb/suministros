@extends('layouts.app')

@section('title', 'Categorías - Sistema de Suministros')

@section('content')
<div class="page-title">Categorías</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <div class="card-header" style="border: none; margin: 0; padding: 0;">
            Listado de Categorías
        </div>
        <a href="{{ route('categorias.create') }}" class="btn btn-primary">
            + Nueva Categoría
        </a>
    </div>

    @if($categorias->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de Categoría</th>
                        <th>Fecha Creación</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->id }}</td>
                        <td>{{ $categoria->nombre_categoria }}</td>
                        <td>{{ $categoria->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" style="justify-content: center;">
                                <a href="{{ route('categorias.show', $categoria) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" style="display: inline;"
                                      onsubmit="return confirm('¿Está seguro de eliminar esta categoría?')">
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
            {{ $categorias->links() }}
        </div>
    @else
        <p class="text-muted">No hay categorías registradas.</p>
    @endif
</div>
@endsection
