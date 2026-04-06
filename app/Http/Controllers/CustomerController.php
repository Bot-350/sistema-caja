<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Muestra la lista de todos los clientes
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    // Muestra el formulario para crear un cliente
    public function create()
    {
        return view('customers.create');
    }

    // Guarda el nuevo cliente
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'email'    => 'nullable|email|max:255',
            'birthday' => 'nullable|date',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    // Muestra el detalle
    public function show(Customer $customer)
    {
        $sales = $customer->sales()->with('items')->latest()->get();
        return view('customers.show', compact('customer', 'sales'));
    }

    // Muestra el formulario para editar
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    // Actualiza el cliente
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'email'    => 'nullable|email|max:255',
            'birthday' => 'nullable|date',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    // Elimina el cliente 
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}