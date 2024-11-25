<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Inventory extends Controller
{
    // Método para generar el reporte de inventario en PDF
    public function inventoryReport(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);
        $products = Product::whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin])->get();


        // Carga la vista del reporte y pasa los productos
        $pdf = PDF::loadView('reports.inventory', compact('products'));

        // Descarga el reporte como PDF
        return $pdf->stream('inventory_report.pdf');
    }

    public function getTopSellingProducts(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);
        // Consultamos los productos más vendidos
        $topSellingProducts = DB::table('sale_items')
        ->join('products', 'sale_items.product_id', '=', 'products.id')
        ->join('sales', 'sale_items.sale_id', '=', 'sales.id') // Relación con las ventas
        ->whereBetween('sales.created_at', [$request->fecha_inicio, $request->fecha_fin]) // Filtrar por fecha
        ->select(
            'products.id',
            'products.name',
            DB::raw('SUM(sale_items.quantity) as total_quantity')
        )
        ->groupBy('products.id', 'products.name')
        ->orderByDesc('total_quantity')
        ->limit(10) // Top 10 productos más vendidos
        ->get();
            $pdf = PDF::loadView('reports.top_selling', compact('topSellingProducts'));
            return $pdf->stream('topinventory_report.pdf');
    }
}
