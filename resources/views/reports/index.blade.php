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
                        <form class="report-form row g-3 align-items-center" action="{{ route('reports.sales') }}" method="POST" target="_blank">
                            @csrf
                            <div class="col-auto">
                                <label for="sales_fecha_inicio" class="form-label">Fecha inicio:</label>
                                <input type="date" class="fecha-inicio form-control border border-gray-300 rounded-lg shadow-sm" name="fecha_inicio" required>
                            </div>
                            <div class="col-auto">
                                <label for="sales_fecha_fin" class="form-label">Fecha fin:</label>
                                <input type="date" class="fecha-fin form-control border border-gray-300 rounded-lg shadow-sm" name="fecha_fin" required>
                            </div>
                            <button type="button" class="btn-submit btn btn-primary mt-3">Generar PDF</button>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div>
                <!-- Botón para el Reporte de Inventarios -->
                <div class="bg-white p-4 rounded-lg shadow-lg flex items-center">
                    <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center text-white mr-4">
                        <i class="fas fa-warehouse fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Reporte de Inventarios</h3>
                        <form class="report-form row g-3 align-items-center" action="{{ route('reports.inventory') }}" method="POST" target="_blank">
                            @csrf
                            <div class="col-auto">
                                <label class="form-label">Fecha inicio:</label>
                                <input type="date" class="fecha-inicio form-control border border-gray-300 rounded-lg shadow-sm" name="fecha_inicio" required>
                            </div>
                            <div class="col-auto">
                                <label class="form-label">Fecha fin:</label>
                                <input type="date" class="fecha-fin form-control border border-gray-300 rounded-lg shadow-sm" name="fecha_fin" required>
                            </div>
                            <button type="button" class="btn-submit btn btn-primary mt-3">Generar PDF</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-4">
            <div>
                <!-- Botón para el Reporte de Productos -->
                <div class="bg-white p-4 rounded-lg shadow-lg flex items-center">
                    <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center text-white mr-4">
                        <i class="fas fa-chart-bar fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Reporte de Productos más Vendidos</h3>
                        <form class="report-form row g-3 align-items-center" action="{{ route('reports.top-selling-products') }}" method="POST" target="_blank">
                            @csrf
                            <div class="col-auto">
                                <label class="form-label">Fecha inicio:</label>
                                <input type="date" class="fecha-inicio form-control border border-gray-300 rounded-lg shadow-sm" name="fecha_inicio" required>
                            </div>
                            <div class="col-auto">
                                <label class="form-label">Fecha fin:</label>
                                <input type="date" class="fecha-fin form-control border border-gray-300 rounded-lg shadow-sm" name="fecha_fin" required>
                            </div>
                            <button type="button" class="btn-submit btn btn-primary mt-3">Generar PDF</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Agregar evento click a todos los botones de envío
        document.querySelectorAll('.btn-submit').forEach(button => {
            button.addEventListener('click', () => {
                // Obtener el formulario correspondiente
                const form = button.closest('.report-form');
                const fechaInicio = form.querySelector('.fecha-inicio').value;
                const fechaFin = form.querySelector('.fecha-fin').value;

                // Validar fechas
                if (!fechaInicio || !fechaFin) {
                    alert('Por favor, completa ambas fechas.');
                    return;
                }

                const inicio = new Date(fechaInicio);
                const fin = new Date(fechaFin);

                if (inicio > fin) {
                    alert('La fecha de inicio no puede ser mayor que la fecha de fin.');
                } else {
                    // Enviar el formulario si las fechas son válidas
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
