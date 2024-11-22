@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
<div class="container">
    <h1 class="mb-4">Crear Producto</h1>

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

        <button type="submit" class="btn btn-primary mt-3">Guardar Producto</button>
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
