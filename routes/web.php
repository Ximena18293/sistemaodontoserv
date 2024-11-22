<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleItemController;

Route::view('/', 'welcome');

// Dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Perfil
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Usuarios
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
});

// Productos
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');
});

// Empleados
Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::get('/create/{user}', [EmployeeController::class, 'showCreateForm'])->name('employees.showCreateForm');
    Route::post('/', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::patch('/{employee}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employees.toggleStatus');
});

// Marcas
Route::prefix('brands')->group(function () {
    Route::get('/', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');
});

// Categorías
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::patch('/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
});

// Clientes
Route::prefix('clients')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::patch('/{client}/toggle-status', [ClientController::class, 'toggleStatus'])->name('clients.toggleStatus');
});

// Ventas
Route::prefix('sales')->group(function () {
    Route::get('/', [SaleController::class, 'index'])->name('sales.index'); // Lista de ventas
    Route::get('/create', [SaleController::class, 'create'])->name('sales.create'); // Crear una nueva venta
    Route::post('/', [SaleController::class, 'store'])->name('sales.store'); // Guardar la venta
    Route::get('/{sale}', [SaleController::class, 'show'])->name('sales.show'); // Detalles de una venta
    Route::get('/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit'); // Editar una venta
    Route::put('/{sale}', [SaleController::class, 'update'])->name('sales.update'); // Actualizar venta
    Route::delete('/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy'); // Eliminar venta
    Route::get('/product', [SaleController::class, 'product'])->name('sales.product'); // Crear una nueva venta
    Route::get('/sales/{sale}/invoice', [SaleController::class, 'generateInvoice'])->name('sales.invoice');
});

// Detalles de venta (SaleItem)
Route::prefix('sales/{sale}/items')->group(function () {
    Route::get('/', [SaleItemController::class, 'index'])->name('sales.items.index'); // Lista de productos de la venta
    Route::post('/', [SaleItemController::class, 'store'])->name('sales.items.store'); // Añadir un producto
    Route::delete('/{item}', [SaleItemController::class, 'destroy'])->name('sales.items.destroy'); // Eliminar un producto
});

Route::get('/report/sales', [SaleController::class, 'salesReport'])->name('reports.sales');

require __DIR__.'/auth.php';
