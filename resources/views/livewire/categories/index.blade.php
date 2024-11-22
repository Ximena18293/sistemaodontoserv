@extends('layouts.app')

@section('header', 'Lista de Categorías')

@section('content')
<div class="container mx-auto px-4">
    <div class="mb-4">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Crear Categoría
        </a>
    </div>

    @if($categories->isEmpty())
        <div class="alert alert-info" role="alert">
            No hay categorías disponibles.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-sm">
                <thead class="bg-yellow-400 text-black border-b border-gray-300">
                    <tr>
                        <th class="py-3 px-4 text-left">#</th>
                        <th class="py-3 px-4 text-left">Nombre</th>
                        <th class="py-3 px-4 text-left">Marca</th>
                        <th class="py-3 px-4 text-left">Estado</th>
                        <th class="py-3 px-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td class="py-2 px-4">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4">{{ $category->name }}</td>
                            <td class="py-2 px-4">{{ $category->brand->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4">
                                <span class="badge {{ $category->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $category->status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="py-2 px-4">
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Editar</a>
                                
                                <form action="{{ route('categories.toggleStatus', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-{{ $category->status ? 'danger' : 'success' }}">
                                        {{ $category->status ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>

                                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
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
