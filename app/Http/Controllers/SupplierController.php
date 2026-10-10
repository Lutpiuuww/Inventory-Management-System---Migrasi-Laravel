<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = \App\Models\Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'contact_info' => 'nullable|string|max:255',
        ]);
        \App\Models\Supplier::create($validated);
        return redirect()->route('suppliers.index')->with('success', 'Supplier ditambahkan.');
    }

    public function edit(\App\Models\Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, \App\Models\Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'contact_info' => 'nullable|string|max:255',
        ]);
        $supplier->update($validated);
        return redirect()->route('suppliers.index')->with('success', 'Supplier diupdate.');
    }

    public function destroy(\App\Models\Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier dihapus.');
    }
}
