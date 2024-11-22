<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Client;
use App\Models\User;
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

        $counter = $lastInvoice ? intval(substr($lastInvoice->invoice_number, -1)) + 1 : 1;
        return "REC-{$date}-{$counter}";
    }

    // Crear una venta
    public function create()
    {
        $clients = Client::all();
        $products = Product::all();
        $items = SaleItem::all();
        return view('livewire.sales.create', compact('clients', 'products','items'));
    }
    public function product()
    {
        $products = Product::all();
        return view('livewire.sales.product', compact('products'));
    }

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
        $sale->total = $total;
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
    public function salesReport()
    {
        // Obtener las ventas con los detalles de los productos vendidos
        $sales = Sale::with('client', 'saleItems.product')->get();

        // Generar el PDF
        $pdf = PDF::loadView('reportes.sales', compact('sales'));

        // Mostrar el PDF en el navegador (en lugar de descargar)
        return $pdf->stream('sales_report.pdf');
    }
    public function destroy($id)
    {
        // Encuentra la venta por ID
        $sale = Sale::findOrFail($id);

        // Cambia el estado a "Inactivo" (0)
        $sale->update(['status' => 0]);

        // Redirige con un mensaje de éxito
        return redirect()->route('sales.index')->with('success', 'La venta ha sido desactivada correctamente.');
    }
    public function edit($id)
    {
        $sale = Sale::findOrFail($id); // Encuentra la venta por ID
        $clients = Client::all(); // Obtén todos los clientes (opcional, si deseas cambiar el cliente)
        
        return view('livewire.sales.update', compact('sale', 'clients'));
    }
    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id); // Encuentra la venta por ID

        // Valida los datos recibidos
        $request->validate([
            'invoice_number' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'total' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'status' => 'required|boolean',
        ]);

        // Actualiza los datos de la venta
        $sale->update([
            'invoice_number' => $request->invoice_number,
            'client_id' => $request->client_id,
            'total' => $request->total,
            'discount' => $request->discount ?? 0,
            'status' => $request->status,
        ]);

        // Redirige con un mensaje de éxito
        return redirect()->route('sales.index')->with('success', 'La venta ha sido actualizada correctamente.');
    }


}
