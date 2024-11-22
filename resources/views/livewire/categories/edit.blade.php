@extends('layouts.app')

@section('title', 'Editar Categoría')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-4">Editar Categoría</h1>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="brand_id" class="form-label">Marca</label>
            <select class="form-select" id="brand_id" name="brand_id" required>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $brand->id == $category->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
            @error('brand_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="name" class="form-label">Nombre de la Categoría</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="form-label">Estado</label>
            <select class="form-select" id="status" name="status" required>
                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Categoría</button>
    </form>
</div>
@endsection
