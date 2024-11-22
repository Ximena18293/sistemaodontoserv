@extends('layouts.app')

@section('title', 'Crear Marca')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-4">Crear Marca</h1>

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

        <button type="submit" class="btn btn-primary">Crear Marca</button>
    </form>
</div>
@endsection
