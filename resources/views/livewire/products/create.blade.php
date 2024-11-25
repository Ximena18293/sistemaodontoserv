@extends('layouts.app')

@section('header', 'Crear Producto')

@section('content')
<div class="container">

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="category">Categoría</label>
            <select id="category" name="category_id" class="form-control" required>
                <option value="">Seleccionar Categoría</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="brand">Marca</label>
            <input type="text" id="brand" class="form-control" disabled>
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="price">Precio</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="status">Estado</label>
            <select name="status" id="status" class="form-control" required>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>

        <div class="d-flex mt-3">
            <button type="submit" class="btn btn-primary me-2">Guardar Producto</button>
            <a href="{{ route('products.index') }}" class="btn btn-info">Volver</a>
        </div>
        
    </form>
</div>
@endsection

@push('scripts')
<script>
    const categories = @json($categories);
    const categorySelect = document.getElementById('category');
    const brandInput = document.getElementById('brand');

    categorySelect.addEventListener('change', function() {
        const selectedCategory = categories.find(c => c.id == this.value);
        brandInput.value = selectedCategory ? selectedCategory.brand.name : '';
    });
</script>
@endpush
