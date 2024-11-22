@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Cliente</h1>

    <form action="{{ route('clients.update', $client->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="company_name">Razón Social</label>
            <input type="text" name="company_name" id="company_name" class="form-control" value="{{ old('company_name', $client->company_name) }}" required>
        </div>

        <div class="form-group">
            <label for="first_name">Nombre</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $client->first_name) }}" required>
        </div>

        <div class="form-group">
            <label for="last_name">Primer Apellido</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $client->last_name) }}">
        </div>

        <div class="form-group">
            <label for="second_last_name">Segundo Apellido</label>
            <input type="text" name="second_last_name" id="second_last_name" class="form-control" value="{{ old('second_last_name', $client->second_last_name) }}">
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $client->email) }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Teléfono</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $client->phone) }}">
        </div>

        <div class="form-group">
            <label for="ciNit">CI/NIT</label>
            <input type="text" name="ciNit" id="ciNit" class="form-control" value="{{ old('ciNit', $client->ciNit) }}" required>
        </div>

        <div class="form-group">
            <label for="status">Estado</label>
            <select name="status" id="status" class="form-control" required>
                <option value="1" {{ $client->status == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $client->status == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Actualizar Cliente</button>
    </form>
</div>
@endsection
