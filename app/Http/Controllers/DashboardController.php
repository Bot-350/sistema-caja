<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        // Total vendido hoy
        $todayTotal = Sale::where('status', 'activa')
            ->whereDate('created_at', today())
            ->sum('total');

        // Número de ventas hoy
        $todaySales = Sale::where('status', 'activa')
            ->whereDate('created_at', today())
            ->count();

        // Total vendido este mes
        $monthTotal = Sale::where('status', 'activa')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // Total de clientes
        $totalCustomers = Customer::count();

        // Últimas 5 ventas
        $latestSales = Sale::with('customer')
            ->latest()
            ->take(5)
            ->get();

        // Productos más vendidos del mes
        $topProducts = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->where('sales.status', 'activa')
            ->whereMonth('sales.created_at', now()->month)
            ->whereYear('sales.created_at', now()->year)
            ->select('sale_items.product_name', DB::raw('SUM(sale_items.quantity) as total_quantity'))
            ->groupBy('sale_items.product_name')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'todayTotal',
            'todaySales',
            'monthTotal',
            'totalCustomers',
            'latestSales',
            'topProducts'
        ));
    }
}