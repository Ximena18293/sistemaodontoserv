@extends('layouts.app')

@section('header', 'Seleccionar Usuario para Empleado')

@section('content')
<div class="container">
    <h2>Seleccionar Usuario</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre Completo</th>
                <th>Correo Electrónico</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }} {{ $user->first_name }} {{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('employees.showCreateForm', $user->id) }}" class="btn btn-primary">Agregar como Empleado</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
