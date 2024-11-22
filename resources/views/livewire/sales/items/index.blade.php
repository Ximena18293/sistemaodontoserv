@extends('layouts.app')

@section('title', 'Productos de la Venta')

@section('content')
<div class="container">
    <h1>Productos de la Venta: {{ $sale->invoice_number }}</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($saleItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->total, 2) }}</td>
                    <td>
                        <form action="{{ route('sales.items.destroy', ['sale_id' => $sale->id, 'item_id' => $item->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Formulario para agregar un nuevo producto -->
    <form action="{{ route('sales.items.store', $sale->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="product_id" class="form-label">Producto</label>
            <select class="form-select" id="product_id" name="product_id" required>
                <option value="">Selecciona un producto</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} - ${{ number_format($product->price, 2) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Cantidad</label>
            <input type="number" id="quantity" name="quantity" class="form-control" required min="1">
        </div>

        <button type="submit" class="btn btn-primary">Agregar Producto</button>
    </form>

    <h3>Total: ${{ number_format($sale->total, 2) }}</h3>
</div>
@endsection
