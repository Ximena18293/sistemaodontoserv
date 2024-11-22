<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - {{ $sale->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007bff;
            font-size: 24px;
            text-align: center;
        }
        p {
            font-size: 16px;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .summary {
            margin-top: 20px;
            font-size: 18px;
        }
        .summary h3 {
            margin: 10px 0;
            font-size: 18px;
        }
        .summary span {
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
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

        <div class="summary">
            <h3>Total: <span>${{ number_format($sale->total, 2) }}</span></h3>
            <h3>Descuento: <span>${{ number_format($sale->discount, 2) }}</span></h3>
            <h3>Total a Pagar: <span>${{ number_format($sale->total - $sale->discount, 2) }}</span></h3>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Mi Empresa</p>
            <p>Gracias por su compra.</p>
        </div>
    </div>
</body>
</html>
