<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Pagina principal de reportes
    public function index(Request $request)
    {
        $type = $request->get('type', 'daily');
        $date = $request->get('date', now()->format('Y-m-d'));
        $month = $request->get('month', now()->format('Y-m'));
        $year = $request->get('year', now()->year);

        // Reporte diario
        if ($type === 'daily') {
            $sales = Sale::with('customer', 'items')
                ->where('status', 'activa')
                ->whereDate('created_at', $date)
                ->get();
            $total = $sales->sum('total');
        }

        // Reporte mensual
        elseif ($type === 'monthly') {
            [$year_m, $month_m] = explode('-', $month);
            $sales = Sale::with('customer', 'items')
                ->where('status', 'activa')
                ->whereMonth('created_at', $month_m)
                ->whereYear('created_at', $year_m)
                ->get();
            $total = $sales->sum('total');
        }

        // Reporte anual
        else {
            $sales = Sale::with('customer', 'items')
                ->where('status', 'activa')
                ->whereYear('created_at', $year)
                ->get();
            $total = $sales->sum('total');
        }

        // Productos más vendidos
        $topProducts = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->where('sales.status', 'activa')
            ->when($type === 'daily', fn($q) => $q->whereDate('sales.created_at', $date))
            ->when($type === 'monthly', function($q) use ($month) {
                [$y, $m] = explode('-', $month);
                return $q->whereMonth('sales.created_at', $m)->whereYear('sales.created_at', $y);
            })
            ->when($type === 'annual', fn($q) => $q->whereYear('sales.created_at', $year))
            ->select('sale_items.product_name', DB::raw('SUM(sale_items.quantity) as total_quantity'), DB::raw('SUM(sale_items.price * sale_items.quantity) as total_amount'))
            ->groupBy('sale_items.product_name')
            ->orderByDesc('total_quantity')
            ->get();

        return view('reports.index', compact(
            'sales', 'total', 'topProducts', 'type', 'date', 'month', 'year'
        ));
    }
}