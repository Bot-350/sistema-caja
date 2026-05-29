<?php

namespace App\Http\Controllers;

use App\Models\CashRegister;
use App\Models\Sale;
use Illuminate\Http\Request;

class CashRegisterController extends Controller
{
    // Muestra el estado actual de la caja
    public function index()
    {
        // Buscar si hay una caja abierta
        $cashRegister = CashRegister::where('status', 'abierta')->latest()->first();

        $ventasEfectivo = 0;
        $ventasQr = 0;
        $saldoActual = 0;

        if ($cashRegister) {
            // Ventas en efectivo desde que se abrió la caja
            $ventasEfectivo = Sale::where('status', 'activa')
                ->where('payment_method', 'efectivo')
                ->where('created_at', '>=', $cashRegister->opened_at)
                ->sum('total');

            // Ventas en QR desde que se abrió la caja
            $ventasQr = Sale::where('status', 'activa')
                ->where('payment_method', 'qr')
                ->where('created_at', '>=', $cashRegister->opened_at)
                ->sum('total');

            // Saldo actual = monto inicial + ventas efectivo
            $saldoActual = $cashRegister->opening_amount + $ventasEfectivo;
        }

        return view('cash.index', compact(
            'cashRegister',
            'ventasEfectivo',
            'ventasQr',
            'saldoActual'
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