<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'category.brand'])->get();
        return view('livewire.products.index', compact('products'));
    }

    public function create()
    {
        // Obtener todas las categorías activas
        $categories = Category::with('brand')->where('status', true)->get();
        return view('livewire.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|boolean',
        ]);

        // Crear el producto
        Product::create($request->only([
            'name',
            'description',
            'price',
            'stock',
            'status',
            'category_id',
        ]));

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Product $product)
    {
        // Obtener las categorías activas para editar
        $categories = Category::with('brand')->where('status', true)->get();
        return view('livewire.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|boolean',
        ]);

        $product->update($request->only([
            'name',
            'description',
            'price',
            'stock',
            'status',
            'category_id',
        ]));

        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado.');
    }

    public function toggleStatus($id)
    {
        // Encuentra el producto por su ID
        $product = Product::findOrFail($id);

        // Cambia el estado del producto (si está activo, lo desactiva, si está inactivo, lo activa)
        $product->status = !$product->status;

        // Guarda los cambios
        $product->save();

        // Redirige a la lista de productos con un mensaje de éxito
        return redirect()->route('products.index')->with('success', 'Estado del producto actualizado correctamente.');
    }

}
