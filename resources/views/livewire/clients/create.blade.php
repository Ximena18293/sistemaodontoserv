@extends('layouts.app')

@section('title', 'Crear Cliente')

@section('content')
<div class="container">
    <h1 class="mb-4">Crear Cliente</h1>

    <form action="{{ route('clients.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="company_name">Razón Social</label>
            <input type="text" name="company_name" id="company_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="first_name">Nombre</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="last_name">Primer Apellido</label>
            <input type="text" name="last_name" id="last_name" class="form-control">
        </div>

        <div class="form-group">
            <label for="second_last_name">Segundo Apellido</label>
            <input type="text" name="second_last_name" id="second_last_name" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone">Teléfono</label>
            <input type="text" name="phone" id="phone" class="form-control">
        </div>

        <div class="form-group">
            <label for="ciNit">CI/NIT</label>
            <input type="text" name="ciNit" id="ciNit" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="status">Estado</label>
            <select name="status" id="status" class="form-control" required>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Guardar Cliente</button>
    </form>
</div>
@endsection
