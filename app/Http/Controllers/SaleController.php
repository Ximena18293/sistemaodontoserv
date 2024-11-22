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
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
        ]);        

        DB::transaction(function () use ($request) {
            $invoiceNumber = $this->generateInvoiceNumber();

            $sale = Sale::create([
                'invoice_number' => $invoiceNumber,
                'client_id' => $request->client_id,
                'total' => 0, // Se actualizará después
                'discount' => $request->discount ?? 0,
                'status' => 1, // Activa
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $saleItem = SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $product->price * $item['quantity'],
                ]);

                $total += $saleItem->total;

                // Actualizar stock del producto
                $product->decrement('stock', $item['quantity']);
            }

            $sale->update(['total' => $total - $sale->discount]);
        });

        return redirect()->route('sales.index')->with('success', 'Venta registrada con éxito.');
    }

    // Generar el PDF de la factura
    public function generateInvoice($id)
    {
        $sale = Sale::with('client', 'saleItems.product')->findOrFail($id);

        $data = [
            'sale' => $sale,
            'items' => $sale->saleItems,
        ];

        $pdf = Pdf::loadView('sales.invoice', $data);

        return $pdf->download('Factura-' . $sale->invoice_number . '.pdf');
    }
}
