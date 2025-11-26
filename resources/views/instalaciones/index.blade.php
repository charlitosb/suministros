@extends('layouts.app')

@section('title', 'Instalaciones de Suministros - Sistema de Suministros')

@section('content')
<div class="page-title">Instalaciones de Suministros</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <div class="card-header" style="border: none; margin: 0; padding: 0;">
            Listado de Instalaciones
        </div>
        <a href="{{ route('instalaciones.create') }}" class="btn btn-warning">
            + Nueva Instalación
        </a>
    </div>

    @if($instalaciones->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Suministro</th>
                        <th>Marca</th>
                        <th>Equipo</th>
                        <th>Tipo Equipo</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instalaciones as $instalacion)
                    <tr>
                        <td>{{ $instalacion->id }}</td>
                        <td>{{ $instalacion->fecha_instalacion->format('d/m/Y') }}</td>
                        <td>{{ $instalacion->suministro->descripcion }}</td>
                        <td>{{ $instalacion->suministro->marca->descripcion }}</td>
                        <td>
                            <strong>{{ $instalacion->equipo->numero_serie }}</strong><br>
                            <small class="text-muted">{{ $instalacion->equipo->descripcion }}</small>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $instalacion->equipo->tipoEquipo->descripcion }}</span>
                        </td>
                        <td>
                            <div class="btn-group" style="justify-content: center;">
                                <a href="{{ route('instalaciones.show', $instalacion) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('instalaciones.edit', $instalacion) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('instalaciones.destroy', $instalacion) }}" method="POST" style="display: inline;"
                                      onsubmit="return confirm('¿Está seguro de eliminar esta instalación? Se devolverá 1 unidad al stock.')">
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
            {{ $instalaciones->links() }}
        </div>
    @else
        <p class="text-muted">No hay instalaciones registradas.</p>
    @endif
</div>
@endsection
