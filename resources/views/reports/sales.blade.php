<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Reporte de Ventas</h1>
    <table>
        <thead>
            <tr>
                <th>ID de Venta</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Descuento</th>
                <th>Total con Descuento</th>
                <th>Productos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->client->company_name }}</td>
                    <td>{{ $sale->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>${{ number_format($sale->total, 2) }}</td>
                    <td>${{ number_format($sale->discount, 2) }}</td>
                    <td>${{ number_format($sale->total - $sale->discount, 2) }}</td>
                    <td>
                        @foreach($sale->saleItems as $item)
                            {{ $item->product->name }} ({{ $item->quantity }})<br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
