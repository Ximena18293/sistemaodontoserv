<!-- resources/views/products/top_selling.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Más Vendidos</title>
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
    <h1>Top 10 Productos Más Vendidos</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre del Producto</th>
                <th>Cantidad Total Vendida</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topSellingProducts as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->total_quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
