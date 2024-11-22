<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleItemController extends Controller
{
    public function index($sale_id)
    {
        $sale = Sale::findOrFail($sale_id);
        $saleItems = SaleItem::where('sale_id', $sale_id)->with('product')->get();
        $products = Product::where('stock', '>', 0)->get(); // Productos con stock disponible
        
        return view('sales.items.index', compact('sale', 'saleItems', 'products'));
    }

    public function store(Request $request, $sale_id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $sale = Sale::findOrFail($sale_id);
        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'No hay suficiente stock para este producto.');
        }

        DB::transaction(function () use ($request, $sale, $product) {
            $saleItem = SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'total' => $product->price * $request->quantity,
            ]);

            $product->decrement('stock', $request->quantity);

            $sale->update(['total' => $sale->total + $saleItem->total]);
        });

        return redirect()->route('sales.items.index', $sale->id)->with('success', 'Producto agregado correctamente.');
    }

    public function destroy($sale_id, $item_id)
    {
        $sale = Sale::findOrFail($sale_id);
        $saleItem = SaleItem::findOrFail($item_id);

        DB::transaction(function () use ($sale, $saleItem) {
            $product = $saleItem->product;
            $product->increment('stock', $saleItem->quantity);

            $sale->update(['total' => $sale->total - $saleItem->total]);

            $saleItem->delete();
        });

        return redirect()->route('sales.items.index', $sale->id)->with('success', 'Producto eliminado de la venta.');
    }
}
