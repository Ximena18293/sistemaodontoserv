@extends('layouts.app')

@section('header', 'Editar Usuario')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Editar Usuario</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="first_name" class="form-label">Primer Apellido</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                @error('first_name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class= "col-md-6">
                <label for="last_name" class="form-label">Segundo Apellido</label>
                 <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}">
                @error('last_name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
        </div>
        </div>

        

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select class="form-select" id="role" name="role" required>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="empleado" {{ old('role', $user->role) == 'empleado' ? 'selected' : '' }}>Empleado</option>
            </select>
            @error('role')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <input type="number" class="form-control" id="status" name="status" value="{{ old('status', $user->status) }}" required>
            @error('status')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
