@extends('layouts.app')

@section('title', 'Lista de Ventas')

@section('content')
<div class="container">
    <h1>Crear Nueva Venta</h1>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form action="{{ route('sales.store')}}" method="POST">
        @csrf
        <input type="hidden" >
        <div class="mb-3">
            <label for="client" class="form-label">Cliente</label>
            <select wire:model="selectedClient" id="client" class="form-select">
                <option value="">Seleccione un cliente</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->company_name }} ({{ $client->ciNit }})</option>
                @endforeach
            </select>
            @error('selectedClient') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <h3>Productos</h3>
        <table class="table" id="table-products">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="list-productos">
                
            </tbody>
        </table>
        <!-- Botón para abrir el modal -->
<button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
    Agregar producto
</button>

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">AGREGAR PRODUCTO</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Buscador -->
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Buscar..." id="in-busc" onkeyup="searchProducts()">
                </div>
                
                <!-- Tabla de productos -->
                <div class="form-group">
                    <table class="table" style="border-collapse: collapse" width="100%">
                        <tbody id="product-list">
                            <!-- Aquí se cargan los productos mediante AJAX o desde el controlador -->
                            @foreach($products as $product)
                                <tr>
                                    <td width="40%">
                                        <img src="{{ asset('img/box-empty.png') }}" alt="prod" width="auto" height="100">
                                    </td>
                                    <td width="60%">
                                        <input type="hidden" class="product-id" value="{{ $product->id }}">
                                        <p class="m-0 p-0 product-name"><b>{{ $product->name }}</b></p>
                                        <p class="m-0 p-0 product-category">{{ $product->category->name }}</p>
                                        <p class="m-0 p-0 product-price">{{ $product->price }}</p>
                                        <div class="d-flex">
                                            <div class="col-6">
                                                <select class="form-control product-quantity">
                                                    <option value="1">1</option>
                                                    @for($i = 2; $i <= $product->stock; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="addProductToSale({{ $product->id }})">AGREGAR</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

        <div class="totals">
            <p>Total productos: $<span id="pagoproductos">0.00</span></p>
            <p>Total a pagar: $<span id="pagototal">0.00</span></p>
        </div>
        <div class="mb-3 mt-3">
            <label for="discount" class="form-label">Descuento</label>
            <input type="number" wire:model="discount" id="discount" class="form-control" min="0">
        </div>


        <button type="submit" class="btn btn-primary">Guardar Venta</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<script>
    function searchProducts() {
    var input = document.getElementById("in-busc");
    var filter = input.value.toUpperCase();
    var table = document.getElementById("product-list");
    var rows = table.getElementsByTagName("tr");
    
    for (var i = 0; i < rows.length; i++) {
        var name = rows[i].getElementsByClassName("product-name")[0];
        if (name) {
            var txtValue = name.textContent || name.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }       
    }
}
function addProductToSale(productId) {
    // Obtén todos los productos disponibles en el modal
    const products = document.querySelectorAll("#product-list tr");
    
    // Encuentra el producto correspondiente
    let selectedProduct = null;
    products.forEach(product => {
        const id = product.querySelector(".product-id").value;
        if (id == productId) {
            selectedProduct = product;
        }
    });

    if (selectedProduct) {
        // Obtén los valores del producto seleccionado
        const idprod = selectedProduct.querySelector(".product-id").value;
        const cant = selectedProduct.querySelector(".product-quantity").value;
        const nombre = selectedProduct.querySelector(".product-name").innerHTML;
        const precio = selectedProduct.querySelector(".product-price").innerHTML;

        // Añade el producto a la tabla de productos seleccionados
        document.getElementById("list-productos").innerHTML += `
            <tr class="fila">
                <td>
                    <input type="hidden" name="p[]" value="${idprod}">
                    <input type="hidden" name="c[]" value="${cant}">
                    <input type="hidden" name="pre[]" value="${precio}">
                    ${idprod}
                </td>
                <td>${nombre}</td>
                <td>${cant}</td>
                <td>${precio}</td>
                <td>
                    <button class="btn btn-danger btn-sm rounded-0" type="button" title="Eliminar producto" onclick="deleteRow(this)">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>`;

        // Calcula el total del producto
        const a1 = parseFloat(cant); // Cantidad
        const a2 = parseFloat(precio); // Precio
        const totalProduct = a1 * a2; // Total por producto
        
        // Actualiza el total
        const valorprod = parseFloat(document.getElementById("pagoproductos").innerHTML) || 0;
        const valortot = parseFloat(document.getElementById("pagototal").innerHTML) || 0;
        
        const newValue = valorprod + totalProduct;
        const newTotal = valortot + totalProduct;

        document.getElementById("pagoproductos").innerHTML = newValue.toFixed(2);
        document.getElementById("pagototal").innerHTML = newTotal.toFixed(2);

        // Muestra el botón de confirmación si no estaba visible
        const boton = document.getElementById("btn-conf-venta");
        boton.style.display = "block";
    }
}
function deleteRow(button) {
    const row = button.closest('tr'); // Encuentra la fila
    row.remove();

    // Recalcula el total después de eliminar
    updateTotal();
}

// Función para actualizar los totales después de eliminar un producto
function updateTotal() {
    let totalProduct = 0;
    let totalSale = 0;

    const rows = document.querySelectorAll("#list-productos tr");
    rows.forEach(row => {
        const cantidad = row.querySelector("input[name='c[]']").value;
        const precio = row.querySelector("input[name='pre[]']").value;

        totalProduct += (parseFloat(cantidad) * parseFloat(precio));
    });

    // Actualiza los totales
    document.getElementById("pagoproductos").innerHTML = totalProduct.toFixed(2);
    document.getElementById("pagototal").innerHTML = totalProduct.toFixed(2);
}

</script>
@endsection

