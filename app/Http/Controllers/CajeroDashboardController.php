<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class CajeroDashboardController extends Controller
{
    // Muestra el dashboard del cajero
    public function __invoke(Request $request)
    {
        // Total vendido hoy por este cajero
        $todayTotal = Sale::where('status', 'activa')
            ->where('user_id', auth()->id())
            ->whereDate('created_at', today())
            ->sum('total');

        // Número de ventas hoy por este cajero
        $todaySales = Sale::where('status', 'activa')
            ->where('user_id', auth()->id())
            ->whereDate('created_at', today())
            ->count();

        // Últimas 5 ventas del cajero
        $latestSales = Sale::with('customer')
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('cajero.dashboard', compact(
            'todayTotal',
            'todaySales',
            'latestSales'
        ));
    }
}