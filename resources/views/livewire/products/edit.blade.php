@extends('layouts.app')

@section('header', 'Editar Producto')

@section('content')
<div class="container">

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <div class="form-group">
            <label for="category">Categoría</label>
            <select id="category" name="category_id" class="form-control" required>
                <option value="">Seleccionar Categoría</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="brand">Marca</label>
            <input type="text" id="brand" class="form-control" value="{{ $product->category->brand->name }}" disabled>
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Precio</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ $product->price }}" required>
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}" required>
        </div>

        <div class="form-group">
            <label for="status">Estado</label>
            <select name="status" id="status" class="form-control" required>
                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Actualizar Producto</button>
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
