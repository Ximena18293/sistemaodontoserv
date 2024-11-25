@extends('layouts.app')

@section('header', 'Lista de Clientes')

@section('content')
<div class="container mx-auto px-4">
    <a href="{{ route('clients.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Agregar Cliente
    </a>

    @if($clients->isEmpty())
        <div class="alert alert-info">No hay clientes disponibles.</div>
    @else
        <div class="overflow-x-auto">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Razón Social</th>
                        <th>Nombre Completo</th>
                        <th>CI/NIT</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $client->company_name }}</td>
                            <td>{{ $client->first_name }} {{ $client->last_name }} {{ $client->second_last_name }}</td>
                            <td>{{ $client->ciNit }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->phone }}</td>
                            <td>
                                <span class="badge {{ $client->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $client->status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 flex space-x-2">
                                <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                                <form action="{{ route('clients.toggleStatus', $client) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-{{ $client->status ? 'danger' : 'success' }} btn-sm">
                                        {{ $client->status ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
