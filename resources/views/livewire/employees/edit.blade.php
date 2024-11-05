@extends('layouts.app')

@section('header', 'Editar Empleado')

@section('content')
<div class="container mt-5">
    <h2>Editar Empleado</h2>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" value="{{ $employee->user->name }} {{ $employee->user->first_name }} {{ $employee->user->last_name }}" disabled>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $employee->address) }}">
            @error('address')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $employee->phone) }}">
            @error('phone')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="position" class="form-label">Cargo</label>
            <select name="position" id="position" class="form-select">
                <option value="Vendedor" {{ $employee->position == 'Vendedor' ? 'selected' : '' }}>Vendedor</option>
                <option value="Gerente" {{ $employee->position == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                <option value="Asistente" {{ $employee->position == 'Asistente' ? 'selected' : '' }}>Asistente</option>
            </select>
            @error('position')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Actualizar Empleado</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
