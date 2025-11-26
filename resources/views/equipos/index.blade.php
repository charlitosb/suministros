@extends('layouts.app')

@section('title', 'Equipos - Sistema de Suministros')

@section('content')
<div class="page-title">Equipos</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <div class="card-header" style="border: none; margin: 0; padding: 0;">
            Listado de Equipos
        </div>
        <a href="{{ route('equipos.create') }}" class="btn btn-primary">
            + Nuevo Equipo
        </a>
    </div>

    @if($equipos->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Número de Serie</th>
                        <th>Descripción</th>
                        <th>Tipo de Equipo</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipos as $equipo)
                    <tr>
                        <td>{{ $equipo->id }}</td>
                        <td><strong>{{ $equipo->numero_serie }}</strong></td>
                        <td>{{ $equipo->descripcion }}</td>
                        <td>
                            <span class="badge badge-info">{{ $equipo->tipoEquipo->descripcion }}</span>
                        </td>
                        <td>
                            <div class="btn-group" style="justify-content: center;">
                                <a href="{{ route('equipos.show', $equipo) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('equipos.destroy', $equipo) }}" method="POST" style="display: inline;"
                                      onsubmit="return confirm('¿Está seguro de eliminar este equipo?')">
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
            {{ $equipos->links() }}
        </div>
    @else
        <p class="text-muted">No hay equipos registrados.</p>
    @endif
</div>
@endsection
