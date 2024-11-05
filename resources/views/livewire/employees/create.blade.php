@extends('layouts.app')

@section('header', 'Registrar Empleado')

@section('content')
<div class="container">
    <h2>Registrar Empleado</h2>

    <form action="{{ route('employees.store') }}" method="POST">
        @csrf

        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <div class="mb-3">
            <label for="name" class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" value="{{ $user->name }} {{ $user->first_name }} {{ $user->last_name }}" disabled>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
            @error('address')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            @error('phone')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="position" class="form-label">Cargo</label>
            <select name="position" class="form-select">
                <option value="Vendedor">Vendedor</option>
                <option value="Gerente">Gerente</option>
                <option value="Asistente">Asistente</option>
            </select>
            @error('position')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Guardar Empleado</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
