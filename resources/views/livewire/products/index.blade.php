@extends('layouts.app')

@section('header', 'Lista de Productos')

@section('content')
<div class="container">
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Agregar Producto
    </a>

    @if($products->isEmpty())
        <div class="alert alert-info">
            No hay productos disponibles.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                {{ $product->category && $product->category->brand ? $product->category->brand->name : 'Sin Marca' }}
                            </td>
                            <td>{{ $product->description }}</td>
                            <td colspan="2" style="font-size: 13px">{{ number_format($product->price, 2) }} Bs.</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 flex space-x-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')"><i class="fas fa-trash"></i></button>
                                </form>
                                <form action="{{ route('products.toggleStatus', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-{{ $product->status ? 'danger' : 'success' }}">
                                        {{ $product->status ? 'Desactivar' : 'Activar' }}
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
