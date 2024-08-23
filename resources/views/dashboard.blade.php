@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Tarjeta de Ventas -->
    <div class="bg-white p-4 rounded-lg shadow-lg flex items-center">
        <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center text-white mr-4">
            <i class="fas fa-dollar-sign fa-2x"></i>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Ventas</h3>
            <p class="text-gray-500">Último mes: $12,000</p>
        </div>
    </div>

    <!-- Tarjeta de Clientes Nuevos -->
    <div class="bg-white p-4 rounded-lg shadow-lg flex items-center">
        <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center text-white mr-4">
            <i class="fas fa-user-plus fa-2x"></i>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Clientes Nuevos</h3>
            <p class="text-gray-500">Último mes: 45</p>
        </div>
    </div>

    <!-- Tarjeta de Inventario -->
    <div class="bg-white p-4 rounded-lg shadow-lg flex items-center">
        <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center text-white mr-4">
            <i class="fas fa-boxes fa-2x"></i>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Inventario</h3>
            <p class="text-gray-500">Productos: 320</p>
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="bg-white p-6 rounded-lg shadow-lg mb-8">
    <h3 class="text-xl font-semibold text-gray-700 mb-4">Estadísticas</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Gráfico de Ventas -->
        <div class="h-64">
            <canvas id="salesChart"></canvas>
        </div>
        <!-- Gráfico de Clientes Nuevos -->
        <div class="h-64">
            <canvas id="newClientsChart"></canvas>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctxSales = document.getElementById('salesChart').getContext('2d');
    new Chart(ctxSales, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            datasets: [{
                label: 'Ventas Mensuales',
                data: [12000, 15000, 17000, 14000, 16000, 19000],
                backgroundColor: 'rgba(255, 205, 86, 0.5)',
                borderColor: 'rgba(255, 205, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctxClients = document.getElementById('newClientsChart').getContext('2d');
    new Chart(ctxClients, {
        type: 'line',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            datasets: [{
                label: 'Clientes Nuevos',
                data: [45, 50, 60, 55, 70, 65],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endsection
