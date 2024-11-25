<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Inventory extends Controller
{
    // Método para generar el reporte de inventario en PDF
    public function inventoryReport()
    {
        // Obtén todos los productos
        $products = Product::all();

        // Carga la vista del reporte y pasa los productos
        $pdf = PDF::loadView('reports.inventory', compact('products'));

        // Descarga el reporte como PDF
        return $pdf->stream('inventory_report.pdf');
    }

    public function getTopSellingProducts()
    {
        // Consultamos los productos más vendidos
        $topSellingProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select('products.id', 'products.name', DB::raw('SUM(sale_items.quantity) as total_quantity'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity')
            ->limit(10) // Limita los resultados a los 10 productos más vendidos
            ->get();
            $pdf = PDF::loadView('reports.top_selling', compact('topSellingProducts'));
            return $pdf->stream('topinventory_report.pdf');
    }
}
