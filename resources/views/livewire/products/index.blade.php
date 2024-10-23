@extends('layouts.app')

@section('header', 'Lista de Productos')

@section('content')
@php
    use App\Models\User;
@endphp
<div class="container mx-auto px-4">
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Crear Producto
        </a>
        <!-- Dropdown para filtrar productos -->
        <form action="{{ route('products.index') }}" method="GET" class="flex items-center">
            <label for="status" class="mr-2 text-gray-700">Mostrar:</label>
            <select id="status" name="status" class="form-select bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Todos</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Disponibles</option>
                <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Agotados</option>
            </select>
        </form>
    </div>

    @if($products->isEmpty())
        <div class="alert alert-info" role="alert">
            No hay productos disponibles.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-sm">
                <thead class="bg-yellow-400 text-black border-b border-gray-300">
                    <tr>
                        <th class="py-3 px-4 text-left">#</th>
                        <th class="py-3 px-4 text-left">Nombre</th>
                        <th class="py-3 px-4 text-left">Descripción</th>
                        <th class="py-3 px-4 text-left">Categoría</th>
                        <th class="py-3 px-4 text-left">Marca</th>
                        <th class="py-3 px-4 text-left">Precio</th>
                        <th class="py-3 px-4 text-left">Stock</th>
                        <th class="py-3 px-4 text-left">Estado</th>
                        <th class="py-3 px-4 text-left">Usuario</th>
                        <th class="py-3 px-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-100">
                            <td class="py-3 px-4">{{ $product->id }}</td>
                            <td class="py-3 px-4">{{ $product->name }}</td>
                            <td class="py-3 px-4">{{ $product->description }}</td>
                            <td class="py-3 px-4">{{ $product->brand }}</td>
                            <td class="py-3 px-4">{{ $product->category }}</td>
                            <td class="py-3 px-4">${{ number_format($product->price, 2) }}</td>
                            <td class="py-3 px-4">{{ $product->stock }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-1 text-sm font-medium rounded-full {{ $product->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->status ? 'Disponible' : 'Agotado' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                {{ optional(User::find($product->user_id))->name }}
                            </td>
                            <td class="py-3 px-4 flex space-x-2">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <form action="{{ route('products.toggleStatus', $product->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-{{ $product->status ? 'danger' : 'success' }} btn-sm">
                                        {{ $product->status ? 'Marcar como Agotado' : 'Marcar como Disponible' }}
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
