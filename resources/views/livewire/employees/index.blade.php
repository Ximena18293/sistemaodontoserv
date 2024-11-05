@extends('layouts.app')

@section('header', 'Lista de Empleados')

@section('content')
<div class="container mx-auto px-4">
    <h2>Lista de Empleados</h2>

    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Agregar Nuevo Empleado
    </a>

    <!-- Dropdown para filtrar empleados -->
    <form action="{{ route('employees.index') }}" method="GET" class="flex items-center mb-3">
        <label for="status" class="mr-2 text-gray-700">Mostrar:</label>
        <select id="status" name="status" class="form-select bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Todos</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activos</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivos</option>
        </select>
    </form>

    @if($employees->isEmpty())
        <div class="alert alert-info" role="alert">
            No hay empleados disponibles.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>Cargo</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->user->name }} {{ $employee->user->first_name }} {{ $employee->user->last_name }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>
                                <span class="badge {{ $employee->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $employee->status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="d-flex">
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm me-2">Editar</a>
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                                </form>
                                <form action="{{ route('employees.toggleStatus', $employee->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-{{ $employee->status ? 'danger' : 'success' }} ms-2">
                                        {{ $employee->status ? 'Desactivar' : 'Activar' }}
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
