@extends('layouts.app')

@section('title', 'Editar Venta')

@section('content')
<div class="container">
    <h1>Editar Venta</h1>

    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="invoice_number" class="form-label">Nro. Factura</label>
            <input type="text" name="invoice_number" id="invoice_number" class="form-control" value="{{ old('invoice_number', $sale->invoice_number) }}" required>
        </div>

        <div class="mb-3">
            <label for="client_id" class="form-label">Cliente</label>
            <select name="client_id" id="client_id" class="form-control" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $client->id == $sale->client_id ? 'selected' : '' }}>
                        {{ $client->razon_social }} (NIT: {{ $client->ciNit }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" step="0.01" name="total" id="total" class="form-control" value="{{ old('total', $sale->total) }}" required>
        </div>

        <div class="mb-3">
            <label for="discount" class="form-label">Descuento</label>
            <input type="number" step="0.01" name="discount" id="discount" class="form-control" value="{{ old('discount', $sale->discount) }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select name="status" id="status" class="form-control">
                <option value="1" {{ $sale->status ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ !$sale->status ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
