@extends('layouts.app')

@section('title', 'Ingresos de Suministros - Sistema de Suministros')

@section('content')
<div class="page-title">Ingresos de Suministros</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <div class="card-header" style="border: none; margin: 0; padding: 0;">
            Listado de Ingresos
        </div>
        <a href="{{ route('ingresos.create') }}" class="btn btn-success">
            + Nuevo Ingreso
        </a>
    </div>

    @if($ingresos->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Suministro</th>
                        <th>Marca</th>
                        <th>Categoría</th>
                        <th style="text-align: center;">Cantidad</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ingresos as $ingreso)
                    <tr>
                        <td>{{ $ingreso->id }}</td>
                        <td>{{ $ingreso->fecha_ingreso->format('d/m/Y') }}</td>
                        <td>{{ $ingreso->suministro->descripcion }}</td>
                        <td>{{ $ingreso->suministro->marca->descripcion }}</td>
                        <td>
                            <span class="badge badge-info">{{ $ingreso->suministro->categoria->nombre_categoria }}</span>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge badge-success">+{{ $ingreso->cantidad }}</span>
                        </td>
                        <td>
                            <div class="btn-group" style="justify-content: center;">
                                <a href="{{ route('ingresos.show', $ingreso) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('ingresos.edit', $ingreso) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('ingresos.destroy', $ingreso) }}" method="POST" style="display: inline;"
                                      onsubmit="return confirm('¿Está seguro de eliminar este ingreso? Se reducirá el stock del suministro.')">
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
            {{ $ingresos->links() }}
        </div>
    @else
        <p class="text-muted">No hay ingresos registrados.</p>
    @endif
</div>
@endsection
