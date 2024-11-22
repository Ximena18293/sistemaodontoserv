@extends('layouts.app')

@section('title', 'Crear Nueva Venta')

@section('content')
<div class="container">
    <h1>Crear Nueva Venta</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        <!-- Cliente -->
        <div class="mb-3">
            <label for="client_id" class="form-label">Cliente</label>
            <select name="client_id" id="client_id" class="form-select" required>
                <option value="">Seleccione un cliente</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->company_name }} ({{ $client->ciNit }})</option>
                @endforeach
            </select>
        </div>

        <!-- Productos -->
        <h3>Productos</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="selected-products">
                <!-- Productos seleccionados se agregarán aquí -->
            </tbody>
        </table>

        <!-- Botón para abrir el modal -->
        <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
            Agregar producto
        </button>

        <!-- Totales -->
        <div class="mb-3">
            <label for="discount" class="form-label">Descuento</label>
            <input type="number" name="discount" id="discount" class="form-control" min="0" step="0.01" value="0">
        </div>
        <div class="totals">
            <p>Total productos: $<span id="total-products">0.00</span></p>
            <p>Total a pagar: $<span id="total-sale">0.00</span></p>
        </div>
        <input type="hidden" name="total" id="total">
        <input type="hidden" name="total_after_discount" id="total_after_discount">
        <button type="submit" class="btn btn-primary">Guardar Venta</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<!-- Modal para agregar productos -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Agregar Producto</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <input type="text" class="form-control" id="product-search" placeholder="Buscar producto..." onkeyup="searchProducts()">
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <b>{{ $product->name }}</b><br>
                                    {{ $product->category->name }}
                                </td>
                                <td>${{ $product->price }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm" onclick="addProduct({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock }})">
                                        Agregar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const selectedProducts = [];

    function addProduct(id, name, price, stock) {
    const existingProduct = selectedProducts.find(p => p.id === id);

    if (existingProduct) {
        alert("El producto ya está agregado.");
        return;
    }

    const quantity = prompt("Ingrese la cantidad:", 1);

    if (!quantity || isNaN(quantity) || quantity <= 0 || quantity > stock) {
        alert(`Ingrese una cantidad válida entre 1 y ${stock}.`);
        return;
    }

    const subtotal = (price * quantity).toFixed(2);

    selectedProducts.push({ id, name, price, quantity, subtotal });

    document.getElementById("selected-products").innerHTML += `
        <tr data-id="${id}">
            <td>${name}</td>
            <td>${quantity}</td>
            <td>${price}</td>
            <td>${subtotal}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(${id})">Eliminar</button>
            </td>
            <input type="hidden" name="items[${id}][product_id]" value="${id}">
            <input type="hidden" name="items[${id}][quantity]" value="${quantity}">
        </tr>
    `;

    updateTotals();
}

function removeProduct(id) {
    const index = selectedProducts.findIndex(p => p.id === id);
    if (index !== -1) {
        selectedProducts.splice(index, 1);
    }

    const row = document.querySelector(`tr[data-id="${id}"]`);
    if (row) {
        row.remove();
    }

    updateTotals();
}

function updateTotals() {
    let total = 0;
    selectedProducts.forEach(p => {
        total += parseFloat(p.subtotal);
    });

    document.getElementById("total-products").textContent = total.toFixed(2);

    const discount = parseFloat(document.getElementById("discount").value || 0);
    const totalSale = total - discount;

    document.getElementById("total-sale").textContent = totalSale.toFixed(2);

    // Actualizar los campos ocultos para enviar los totales
    document.getElementById("total").value = total.toFixed(2);
    document.getElementById("total_after_discount").value = totalSale.toFixed(2);
}

document.getElementById("discount").addEventListener("input", updateTotals);

function searchProducts() {
    const input = document.getElementById("product-search").value.toUpperCase();
    const rows = document.querySelectorAll("#product-list tr");

    rows.forEach(row => {
        const productName = row.querySelector("td:first-child").textContent.toUpperCase();
        row.style.display = productName.includes(input) ? "" : "none";
    });
}
</script>
@endsection
