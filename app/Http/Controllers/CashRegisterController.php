<?php

namespace App\Http\Controllers;

use App\Models\CashMovement;
use App\Models\CashRegister;
use App\Models\Sale;
use Illuminate\Http\Request;

class CashRegisterController extends Controller
{
    // Muestra el estado actual de la caja
    public function index()
    {
        // Buscar si hay una caja abierta
        $cashRegister = CashRegister::with(['user', 'movements.user'])
            ->where('status', 'abierta')
            ->latest()
            ->first();

        $summaryCashRegister = $cashRegister ?? CashRegister::with(['user', 'movements.user'])
            ->latest()
            ->first();

        $saldoInicial = 0;
        $ventasEfectivo = 0;
        $ventasQr = 0;
        $ingresosManuales = 0;
        $egresosManuales = 0;
        $totalIngresos = 0;
        $totalEgresos = 0;
        $saldoActual = 0;
        $movements = collect();

        if ($summaryCashRegister) {
            $saldoInicial = $summaryCashRegister->opening_amount;

            $salesQuery = $summaryCashRegister->sales();

            // Ventas en efectivo del resumen diario
            $ventasEfectivo = (clone $salesQuery)
                ->where('payment_method', 'efectivo')
                ->sum('total');

            // Ventas en QR del resumen diario
            $ventasQr = (clone $salesQuery)
                ->where('payment_method', 'qr')
                ->sum('total');

            $ingresosManuales = $summaryCashRegister->movements()
                ->where('type', 'income')
                ->sum('amount');

            $egresosManuales = $summaryCashRegister->movements()
                ->where('type', 'expense')
                ->sum('amount');

            $movements = $summaryCashRegister->movements()->with('user')->latest()->get();

            $totalIngresos = $saldoInicial + $ventasEfectivo + $ventasQr + $ingresosManuales;
            $totalEgresos = $egresosManuales;

            // Saldo actual = monto inicial + ventas efectivo + ventas QR + ingresos manuales - egresos manuales
            $saldoActual = $totalIngresos - $totalEgresos;
        }

        return view('cash.index', compact(
            'cashRegister',
            'summaryCashRegister',
            'saldoInicial',
            'ventasEfectivo',
            'ventasQr',
            'ingresosManuales',
            'egresosManuales',
            'totalIngresos',
            'totalEgresos',
            'saldoActual',
            'movements'
        ));
    }

    // Abre la caja
    public function open(Request $request)
    {
        $request->validate([
            'opening_amount' => 'required|numeric|min:0'
        ]);

        CashRegister::create([
            'user_id'        => auth()->id(),
            'opening_amount' => $request->opening_amount,
            'status'         => 'abierta',
            'opened_at'      => now(),
        ]);

        return redirect()->route('cash.index')
            ->with('success', 'Caja abierta correctamente.');
    }

    // Registra un ingreso o egreso manual
    public function storeMovement(Request $request)
    {
        $request->validate([
            'type'   => 'required|in:ingreso,egreso',
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string|max:255',
        ]);

        $cashRegister = CashRegister::where('status', 'abierta')->latest()->first();

        if (!$cashRegister) {
            return redirect()->route('cash.index')
                ->with('error', 'Debes abrir la caja antes de registrar movimientos.');
        }

        CashMovement::create([
            'cash_register_id' => $cashRegister->id,
            'user_id'          => auth()->id(),
            'type'             => $request->type,
            'amount'           => $request->amount,
            'reason'           => $request->reason,
        ]);

        return redirect()->route('cash.index')
            ->with('success', 'Movimiento registrado correctamente.');
    }

    // Cierra la caja
    public function close()
    {
        $cashRegister = CashRegister::where('status', 'abierta')->latest()->first();

        if (!$cashRegister) {
            return redirect()->route('cash.index')
                ->with('error', 'No hay una caja abierta.');
        }

        $cashRegister->update([
            'status'    => 'cerrada',
            'closed_at' => now(),
        ]);

        return redirect()->route('cash.index')
            ->with('success', 'Caja cerrada correctamente.');
    }
}