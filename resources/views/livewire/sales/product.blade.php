@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
<div class="container">
    <h1>Crear Nuevo Producto</h1>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save">
        <!-- Nombre del Producto -->
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" wire:model="name" id="name" class="form-control" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Categoría -->
        

        <!-- Descripción del Producto -->
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea wire:model="description" id="description" class="form-control"></textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Precio -->
        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" wire:model="price" id="price" class="form-control" required min="0">
            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Stock -->
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" wire:model="stock" id="stock" class="form-control" required min="0">
            @error('stock') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Botones -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Guardar Producto</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
