@extends('layouts.app')

@section('header', 'Editar Marca') <!-- Cambia esto para reflejar que es una edición -->

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-4">Editar Marca</h1>

    <form action="{{ route('brands.update', $brand) }}" method="POST"> <!-- Cambia esto a update -->
        @csrf
        @method('PUT') <!-- Agrega este método para indicar que es una actualización -->

        <div class="mb-4">
            <label for="name" class="form-label">Nombre de la Marca</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $brand->name) }}" required> <!-- Asegúrate de obtener el valor actual -->
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $brand->description) }}</textarea> <!-- Asegúrate de obtener el valor actual -->
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Marca</button>
    </form>
</div>
@endsection
