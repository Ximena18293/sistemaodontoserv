@extends('layouts.app')

@section('header', 'Reportes')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div>
                <!-- Botón para el Reporte de Ventas -->
                <div class="bg-white p-4 rounded-lg shadow-lg flex items-center">
                    <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center text-white mr-4">
                        <i class="fas fa-file-invoice-dollar fa-2x"></i>
                    </div>
                    <div class="">
                        <h3 class="text-lg font-semibold text-gray-700">Reporte de Ventas</h3>
                        <form action="" class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="fecha_inicio" class="form-label">Fecha inicio:</label>
                                <input type="date" id="fecha_inicio" class="form-control border border-gray-300 rounded-lg shadow-sm">
                            </div>
                            <div class="col-auto">
                                <label for="fecha_fin" class="form-label">Fecha fin:</label>
                                <input type="date" id="fecha_fin" class="form-control border border-gray-300 rounded-lg shadow-sm">
                            </div>
                        </form>
                        <a href="{{ route('reports.sales') }}" target="_blank" class="btn btn-primary mt-3">
                            Generar PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div>
                <!-- Botón para el Reporte de Ventas -->
                <div class="bg-white p-4 rounded-lg shadow-lg flex items-center">
                    <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center text-white mr-4">
                        <i class="fas fa-warehouse fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Reporte de Inventarios</h3>
                        <form action="" class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="fecha_inicio" class="form-label">Fecha inicio:</label>
                                <input type="date" id="fecha_inicio" class="form-control border border-gray-300 rounded-lg shadow-sm">
                            </div>
                            <div class="col-auto">
                                <label for="fecha_fin" class="form-label">Fecha fin:</label>
                                <input type="date" id="fecha_fin" class="form-control border border-gray-300 rounded-lg shadow-sm">
                            </div>
                        </form>
                        <a href="{{ route('reports.inventory') }}" target="_blank" class="btn btn-primary mt-3">
                            Generar PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <div>
                <!-- Botón para el Reporte de Ventas -->
                <div class="bg-white p-4 rounded-lg shadow-lg flex items-center">
                    <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center text-white mr-4">
                        <i class="fas fa-chart-bar fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Reporte de Prpductos más vendidos </h3>
                        <form action="" class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="fecha_inicio" class="form-label">Fecha inicio:</label>
                                <input type="date" id="fecha_inicio" class="form-control border border-gray-300 rounded-lg shadow-sm">
                            </div>
                            <div class="col-auto">
                                <label for="fecha_fin" class="form-label">Fecha fin:</label>
                                <input type="date" id="fecha_fin" class="form-control border border-gray-300 rounded-lg shadow-sm">
                            </div>
                        </form>
                        <a href="{{ route('reports.top-selling-products') }}" target="_blank" class="btn btn-primary mt-3">
                            Generar PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
