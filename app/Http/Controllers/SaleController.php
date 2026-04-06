<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    // Muestra la lista de las ventas
    public function index()
    {
        $sales = Sale::with('customer')->latest()->get();
        return view('sales.index', compact('sales'));
    }

    // Muestra el formulario para crear una venta
    public function create()
    {
        $products = Product::with('category')->get();
        $customers = Customer::all();
        return view('sales.create', compact('products', 'customers'));
    }

    // Guarda la nueva venta 
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'    => 'nullable|exists:customers,id',
            'payment_method' => 'required|in:efectivo,qr',
            'items'          => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            // Calcular el total
            $total = 0;
            $items = [];

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                $items[] = [
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'quantity'     => $item['quantity'],
                    'price'        => $product->price,
                ];
            }

            // Generar nmero de venta automático
            $lastSale = Sale::latest()->first();
            $number = $lastSale ? str_pad($lastSale->id + 1, 6, '0', STR_PAD_LEFT) : '000001';

            // Crear la venta
            $sale = Sale::create([
                'number'         => $number,
                'customer_id'    => $request->customer_id,
                'user_id'        => auth()->id(),
                'user_name'      => auth()->user()->name,
                'payment_method' => $request->payment_method,
                'status'         => 'activa',
                'total'          => $total,
            ]);

            // Guardar los items
            $sale->items()->createMany($items);

            // Incrementar visitas del cliente si hay uno
            if ($request->customer_id) {
                Customer::find($request->customer_id)->increment('visit_count');
            }
        });

        return redirect()->route('sales.index')
            ->with('success', 'Venta registrada correctamente.');
    }

    // Muestra el detalle de una venta
    public function show(Sale $sale)
    {
        $sale->load('items', 'customer');
        return view('sales.show', compact('sale'));
    }

    // Anula una venta
    public function destroy(Sale $sale)
    {
        if ($sale->status === 'anulada') {
            return redirect()->route('sales.index')
                ->with('error', 'Esta venta ya está anulada.');
        }

        $sale->update(['status' => 'anulada']);

        // Decrementar visitas del cliente si hay uno
        if ($sale->customer_id) {
            Customer::find($sale->customer_id)->decrement('visit_count');
        }

        return redirect()->route('sales.index')
            ->with('success', 'Venta anulada correctamente.');
    }
}