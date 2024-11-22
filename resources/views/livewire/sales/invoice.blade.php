<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - {{ $sale->invoice_number }}</title>
</head>
<body>
    <h1>Factura: {{ $sale->invoice_number }}</h1>
    <p><strong>Cliente:</strong> {{ $sale->client->company_name }} ({{ $sale->client->ciNit }})</p>
    <p><strong>Fecha:</strong> {{ $sale->created_at->format('d/m/Y') }}</p>

    <h3>Productos</h3>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total: ${{ number_format($sale->total, 2) }}</h3>
    <h3>Descuento: ${{ number_format($sale->discount, 2) }}</h3>
    <h3>Total a Pagar: ${{ number_format($sale->total - $sale->discount, 2) }}</h3>
</body>
</html>
