<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');

        if ($status === 'available') {
            $products = Product::where('status', 1)->get();
        } elseif ($status === 'out_of_stock') {
            $products = Product::where('status', 0)->get();
        } else {
            $products = Product::all();
        }

        return view('livewire/products.index', compact('products'));
    }

    public function create()
    {
        return view('livewire/products.create');
    }

    public function edit(Product $product)
    {
        return view('livewire/products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|integer|in:0,1',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 100 caracteres.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'category.string' => 'La categoría debe ser una cadena de texto.',
            'category.max' => 'La categoría no puede tener más de 50 caracteres.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio debe ser al menos 0.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock debe ser al menos 0.',
            'status.required' => 'El estado es obligatorio.',
            'status.integer' => 'El estado debe ser un número entero.',
            'status.in' => 'El estado debe ser 0 o 1.',
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|integer|in:0,1',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 100 caracteres.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'category.string' => 'La categoría debe ser una cadena de texto.',
            'category.max' => 'La categoría no puede tener más de 50 caracteres.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio debe ser al menos 0.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock debe ser al menos 0.',
            'status.required' => 'El estado es obligatorio.',
            'status.integer' => 'El estado debe ser un número entero.',
            'status.in' => 'El estado debe ser 0 o 1.',
        ]);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->status = !$product->status;
        $product->user_id = Auth::id();
        $product->save();

        return redirect()->route('products.index')->with('success', 'Estado del producto actualizado correctamente.');
    }
}
