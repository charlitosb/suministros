@extends('layouts.app')

@section('title', 'Tipos de Equipo - Sistema de Suministros')

@section('content')
<div class="page-title">Tipos de Equipo</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <div class="card-header" style="border: none; margin: 0; padding: 0;">
            Listado de Tipos de Equipo
        </div>
        <a href="{{ route('tipos-equipo.create') }}" class="btn btn-primary">
            + Nuevo Tipo
        </a>
    </div>

    @if($tiposEquipo->count() > 0)
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
                    @foreach($tiposEquipo as $tipo)
                    <tr>
                        <td>{{ $tipo->id }}</td>
                        <td>{{ $tipo->descripcion }}</td>
                        <td>{{ $tipo->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" style="justify-content: center;">
                                <a href="{{ route('tipos-equipo.show', $tipo) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('tipos-equipo.edit', $tipo) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('tipos-equipo.destroy', $tipo) }}" method="POST" style="display: inline;"
                                      onsubmit="return confirm('¿Está seguro de eliminar este tipo de equipo?')">
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
            {{ $tiposEquipo->links() }}
        </div>
    @else
        <p class="text-muted">No hay tipos de equipo registrados.</p>
    @endif
</div>
@endsection
