@extends('layouts.app')

@section('title', 'Crear Categoría')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-4">Crear Categoría</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="brand_id" class="form-label">Marca</label>
            <select class="form-select" id="brand_id" name="brand_id" required>
                <option value="">Seleccionar Marca</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
            @error('brand_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="name" class="form-label">Nombre de la Categoría</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="form-label">Estado</label>
            <select class="form-select" id="status" name="status" required>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Crear Categoría</button>
    </form>
</div>
@endsection
