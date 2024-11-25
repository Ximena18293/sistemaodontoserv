<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario</title>
    <style>
        /* Establece el tamaño de la página en formato carta */
        @page {
            size: 21.59cm 27.94cm; /* Tamaño carta: 8.5 x 11 pulgadas */
            margin: 1cm; /* Márgenes de la página */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        /* Contenedor para que todo el contenido se ajuste dentro del área imprimible */
        .content {
            width: 100%;
            margin: 0 auto;
            padding: 1cm; /* Para evitar que el contenido se salga del margen */
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Para evitar que las celdas se expandan más allá del límite */
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            word-wrap: break-word; /* Asegura que el texto largo no desborde */
        }

        th {
            background-color: #f4f4f4;
        }

        /* Asegura que las celdas no se estiren más allá del espacio disponible */
        td {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Reporte de Inventario</h1>
        <table>
            <thead>
                <tr>
                    <th>ID Producto</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad en Stock</th>
                    <th>Estado</th>
                    <th>Responsable</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->status == 1 ? 'Activo' : 'Inactivo' }}</td>
                        <td>{{ $product->user ? $product->user->name : 'No asignado' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
