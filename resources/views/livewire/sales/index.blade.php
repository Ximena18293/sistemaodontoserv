@extends('layouts.app')

@section('title', 'Lista de Ventas')

@section('content')
<div class="container">
    <h1>Lista de Ventas</h1>

    <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Agregar Venta
    </a>

    @if($sales->isEmpty())
        <div class="alert alert-info">
            No hay ventas registradas.
        </div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nro. Factura</th>
                    <th>Razón Social</th>
                    <th>NIT</th>
                    <th>Total</th>
                    <th>Descuento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->invoice_number }}</td>
                        <td>{{ $sale->client->company_name }}</td>
                        <td>{{ $sale->client->ciNit }}</td>
                        <td>{{ number_format($sale->total, 2) }}</td>
                        <td>{{ number_format($sale->discount, 2) }}</td>
                        <td>{{ $sale->status ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
