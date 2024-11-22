<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('brand')->get();
        return view('livewire.categories.index', compact('categories'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all();
        return view('livewire.categories.create', compact('brands'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $brands = Brand::all();
        return view('livewire.categories.edit', compact('category', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Categoría eliminada exitosamente.');

    }

    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);

        // Cambiar el estado
        $category->status = !$category->status;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Estado de la categoría actualizado correctamente.');
    }

}
