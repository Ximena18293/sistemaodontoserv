<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante - {{ $sale->invoice_number }}</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between; /* Coloca los elementos en lados opuestos */
            align-items: center; /* Alinea verticalmente ambos elementos */
            width: 100%;
            margin-bottom: 20px;
        }

        .logo {
            width: 150px; /* Tamaño fijo del logo */
        }

        .logo img {
            width: 100%; /* Ajusta el logo al contenedor */
            height: auto;
        }

        .info {
            flex: 1; /* Usa el espacio restante para la info */
            text-align: right; /* Texto alineado a la derecha */
            font-size: 14px;
            line-height: 1.5;
            margin-left: 20px; /* Espacio entre logo e info */
        }

        .info p {
            margin: 0; /* Elimina los márgenes verticales entre líneas */
        }

        .content {
            margin: 20px 0;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .products-table th, .products-table td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        .products-table th {
            background-color: #63bde7;
            color: #141313;
        }

        .summary {
            margin-top: 20px;
            font-size: 18px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }

        /* Responsivo */
        @media (max-width: 600px) {
            .header {
                flex-direction: column; /* Cambia a disposición vertical en pantallas pequeñas */
                text-align: center;
            }

            .info {
                text-align: center; /* Centra el texto */
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            <!-- Logo a la izquierda -->
            <table>
                <tr>
                    <td><img src="logoodontoserv.png" alt="Logo OdontoServ" style="width: 150px;"></td>
                    <td style="text-align: right; padding-left:150px;">
                        <center>
                            <p style="font-size: 13px;">Av. Ayacucho esq. General Acha, Edif. <br> María Antonieta, Piso 6 Of. 2, <br> Cochabamba, Bolivia</p>
                        </center>
                        <p style="text-align: left; font-size: 13px">Celular: 67404568</p>
                        <p style="font-size: 13px">Correo: odontoservboliviaweb@gmail.com</p>
                    </td>
                </tr>
            </table>
                
            

            <!-- Información a la derecha -->
            
            
        </div>

        <h1 style="text-align: center;">Comprobante de Venta</h1>

        <!-- Contenido -->
        <div class="content">
            <p style="margin: 2;"><strong>Nro:</strong> {{ $sale->invoice_number }}</p>
        <table style="margin: 0;">
            <tr style="margin: 0;">
                <td><p style="margin: 0;"><strong>Fecha:</strong> {{ $sale->created_at->format('d/m/Y') }}</p></td>
                <td style="padding-left: 230px;"><p style="margin: 0;"><strong>Hora:</strong> {{ $sale->created_at->format('H:i:s') }}</p></td>
            </tr>
        </table>
        <p style="margin: 2;"><strong>Nombre/Razón Social:</strong> {{ $sale->client->company_name }}</p>
        <p style="margin: 2;"><strong>NIT/CI:</strong> {{ $sale->client->ciNit }}</p>

            <!-- Tabla de productos -->
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>P.Unitario</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Descuento</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalSum = 0;
                    @endphp
                    @foreach ($items as $item)
                        @php
                            // Cálculo corregido del importe por fila
                            $rowTotal = ($item->price * $item->quantity) - $sale->discount;
                            $totalSum += $rowTotal;
                        @endphp
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ number_format($item->price, 2) }}Bs.</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price * $item->quantity, 2) }}Bs.</td>
                            <td>{{ number_format($sale->discount, 2) }}Bs.</td>
                            <td>{{ number_format($rowTotal, 2) }}Bs.</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <th style="font-size: 13px">Total general</th>
                        <th style="font-size: 13px">{{ number_format($totalSum, 2) }} Bs.</th>
                    </tr>
                </tfoot>
            </table>

        </div>

        <!-- Pie de página -->
        <div class="footer">
            <p>ODONTOSERV “ÚNICO REPRESENTANTE A NIVEL NACIONAL ORMCO”</p>
            <p>Gracias por su compra</p>
        </div>
    </div>
</body>
</html>
