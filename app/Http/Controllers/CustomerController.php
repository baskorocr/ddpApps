<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all customers
        $customers = Customer::all();

        // Return the view and pass the $customers data
        return view('customers.index', compact('customers'));
    }
    // Show the form for creating a new resource
    public function create()
    {
        return view('customers.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|array',
            'name.*' => 'required|string|max:255',
        ]);

        // Loop untuk menyimpan beberapa pelanggan sekaligus
        foreach ($request->name as $name) {
            Customer::create(['name' => $name]);
        }

        return response()->json(['message' => 'Customers added successfully'], 200);
    }


    // Display the specified resource
    public function show(customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    // Show the form for editing the specified resource
    public function edit(customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    // Update the specified resource in storage
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $customer->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully!',
        ]);
    }

    // Remove the specified resource from storage
    public function destroy(customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'customer deleted successfully.');
    }
}