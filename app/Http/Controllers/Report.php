<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Sale;

class Report extends Controller
{
    public function salesReport()
    {
        return redirect()->route('reports.sales');
    }
    public function salesReport(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // Obtener los datos para el reporte (reemplaza con tu lógica real)
        $sales = \App\Models\Sale::whereBetween('created_at', [
            $request->fecha_inicio,
            $request->fecha_fin,
        ])->get();

        // Generar PDF con DomPDF
        $pdf = PDF::loadView('reportes.sales', compact('sales'));
        return $pdf->download('reporte-ventas.pdf');
    }

    /**
     * Genera el reporte de inventarios.
     */
    public function inventoryReport(Request $request)
    {
        
    }

    /**
     * Genera el reporte de productos más vendidos.
     */
    public function topSellingProductsReport(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // Obtener los datos para el reporte (reemplaza con tu lógica real)
        $topProducts = \App\Models\Product::select('name', \DB::raw('SUM(quantity) as total_sold'))
            ->join('sales_items', 'products.id', '=', 'sales_items.product_id')
            ->whereBetween('sales_items.created_at', [
                $request->fecha_inicio,
                $request->fecha_fin,
            ])
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->get();

        // Generar PDF con DomPDF
        $pdf = PDF::loadView('reports.top-selling-products-pdf', compact('topProducts'));
        return $pdf->download('reporte-productos-mas-vendidos.pdf');
    }
}
