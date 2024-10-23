@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')

<div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-4">Crear Producto</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category" class="form-label">Categoría</label>
                <input type="text" class="form-control" id="category" name="category" value="{{ old('category') }}">
                @error('category')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="brand" class="form-label">Marca</label>
                <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand') }}">
                @error('brand')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" required>
                @error('stock')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="form-label">Estado</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Crear Producto</button>
    </form>
</div>
@endsection
