@extends('layouts.app')

@section('header', 'Crear Marca')

@section('content')
<div class="container mx-auto px-4">

    <form action="{{ route('brands.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="form-label">Nombre de la Marca</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex mt-3">
            <button type="submit" class="btn btn-primary me-2">Crear Marca</button>
            <a href="{{ route('brands.index') }}" class="btn btn-info">Volver</a>
        </div>
    </form>
</div>
@endsection
