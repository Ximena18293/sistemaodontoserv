<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Client;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class SaleController extends Controller
{
    // Mostrar la lista de ventas
    public function index()
    {
        $sales = Sale::with('client')->get(); // Carga la relación con cliente
        return view('livewire.sales.index', compact('sales'));
    }

    // Generar el número de factura
    public function generateInvoiceNumber()
    {
        $date = now()->format('ymd'); // Formato: YYMMDD
        $lastInvoice = Sale::whereDate('created_at', today())->latest()->first();

        $counter = $lastInvoice ? intval(substr($lastInvoice->invoice_number, -3)) + 1 : 1;
        return "REC-{$date}-" . str_pad($counter, 3, '0', STR_PAD_LEFT);
    }

    // Crear una venta
    public function create()
    {
        $clients = Client::all();
        $products = Product::all();
        return view('livewire.sales.create', compact('clients', 'products'));
    }

    // Almacenar la venta
    public function store(Request $request)
    {
        $userId = auth()->id();

        // Validación de los datos del formulario
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
        ]);

        // Obtener los datos del cliente
        $client = Client::find($validated['client_id']);

        // Crear la venta
        $sale = new Sale();
        $sale->client_id = $client->id;
        $sale->invoice_number = $this->generateInvoiceNumber(); // Generar número de factura
        $sale->total = 0;
        $sale->discount = $validated['discount'] ?? 0;
        $sale->user_id = auth()->id();
        $sale->save();

        // Inicializar el total de la venta
        $total = 0;

        // Guardar los productos de la venta
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            
            // Calcular el total para este producto
            $totalProduct = $product->price * $item['quantity'];
    
            // Crear un registro en SaleItem
            $saleItem = SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'total' => $totalProduct,
            ]);
    
            // Sumar el total del producto al total general de la venta
            $total += $saleItem->total;
    
            // Actualizar stock del producto
            $product->decrement('stock', $item['quantity']);
        }

        // Aplicar el descuento
        $totalAfterDiscount = $total - ($validated['discount'] ?? 0);

        // Actualizar el total de la venta
        $sale->total = $totalAfterDiscount;
        $sale->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('sales.create')->with('success', 'Venta creada exitosamente.');
    }

    // Generar el PDF de la factura
    public function generateInvoice($id)
    {
        $sale = Sale::with('client', 'saleItems.product')->findOrFail($id);

        $data = [
            'sale' => $sale,
            'items' => $sale->saleItems,
        ];

        $pdf = Pdf::loadView('livewire.sales.invoice', $data);

        return $pdf->stream('Factura-' . $sale->invoice_number . '.pdf');
    }

    // Generar reporte de ventas
    public function salesReport(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);
        $sales = Sale::whereBetween('created_at', [
            $request->fecha_inicio,
            $request->fecha_fin,
        ])->get();

        $pdf = PDF::loadView('reports.sales', compact('sales'));

        return $pdf->stream('sales_report.pdf');
    }

    // Desactivar una venta (eliminación lógica)
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);

        // Cambiar estado a "Inactivo"
        $sale->update(['status' => 0]);

        return redirect()->route('sales.index')->with('success', 'La venta ha sido desactivada correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        $clients = Client::all();

        return view('livewire.sales.update', compact('sale', 'clients'));
    }

    // Actualizar una venta
    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);

        // Validar los datos recibidos
        $validated = $request->validate([
            'invoice_number' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'total' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'status' => 'required|boolean',
        ]);

        // Actualizar los datos de la venta
        $sale->update([
            'invoice_number' => $validated['invoice_number'],
            'client_id' => $validated['client_id'],
            'total' => $validated['total'],
            'discount' => $validated['discount'] ?? 0,
            'status' => $validated['status'],
        ]);

        return redirect()->route('sales.index')->with('success', 'La venta ha sido actualizada correctamente.');
    }
}