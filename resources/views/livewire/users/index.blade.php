@extends('layouts.app')

@section('header', 'Lista de Usuarios')

@section('content')
@php
    use App\Models\User;
@endphp
<div class="container mx-auto px-4">
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Crear Usuario
        </a>
        <!-- Dropdown para filtrar usuarios -->
        <form action="{{ route('users.index') }}" method="GET" class="flex items-center">
            <label for="status" class="mr-2 text-gray-700">Mostrar:</label>
            <select id="status" name="status" class="form-select bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Todos</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Habilitados</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Deshabilitados</option>
            </select>
        </form>
    </div>

    @if($users->isEmpty())
        <div class="alert alert-info" role="alert">
            No hay usuarios disponibles.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-sm">
                <thead class="bg-yellow-400 text-black border-b border-gray-300">
                    <tr>
                        <th class="py-3 px-4 text-left">#</th>
                        <th class="py-3 px-4 text-left">Nombre Completo</th>
                        <th class="py-3 px-4 text-left">Email</th>
                        <th class="py-3 px-4 text-left">Rol</th>
                        <th class="py-3 px-4 text-left">Estado</th>
                        <th class="py-3 px-4 text-left">Usuario</th>
                        <th class="py-3 px-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-100">
                            <td class="py-3 px-4">{{ $user->id }}</td>
                            <td class="py-3 px-4">{{ $user->name }} {{ $user->first_name }} {{ $user->last_name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">{{ $user->role }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-1 text-sm font-medium rounded-full {{ $user->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                {{ optional(User::find($user->user_id))->name }}
                            </td>
                            <td class="py-3 px-4 flex space-x-2">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-{{ $user->status ? 'danger' : 'success' }} btn-sm">
                                        {{ $user->status ? 'Desactivar' : 'Activar' }}
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
