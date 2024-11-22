@extends('layouts.app')

@section('header', 'Lista de Marcas')

@section('content')
<div class="container mx-auto px-4">
    <div class="mb-4">
        <a href="{{ route('brands.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Crear Marca
        </a>
    </div>

    @if($brands->isEmpty())
        <div class="alert alert-info" role="alert">
            No hay marcas disponibles.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-sm">
                <thead class="bg-yellow-400 text-black border-b border-gray-300">
                    <tr>
                        <th class="py-3 px-4 text-left">#</th>
                        <th class="py-3 px-4 text-left">Nombre</th>
                        <th class="py-3 px-4 text-left">Descripción</th>
                        <th class="py-3 px-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($brands as $brand)
                        <tr class="hover:bg-gray-100">
                            <td class="py-3 px-4">{{ $loop->iteration  }}</td>
                            <td class="py-3 px-4">{{ $brand->name }}</td>
                            <td class="py-3 px-4">{{ $brand->description }}</td>
                            <td class="py-3 px-4 flex space-x-2">
                                <a href="{{ route('brands.edit', $brand) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('brands.destroy', $brand) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                        <i class="fas fa-trash"></i>
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
