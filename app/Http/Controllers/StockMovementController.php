<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movements = \App\Models\StockMovement::with(['product', 'user'])->latest()->paginate(10);
        return view('stock_movements.index', compact('movements'));
    }

    public function create()
    {
        $products = \App\Models\Product::orderBy('name')->get();
        return view('stock_movements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $product = \App\Models\Product::findOrFail($validated['product_id']);

        if ($validated['type'] === 'out' && $product->stock < $validated['quantity']) {
            return back()->with('error', 'Stok tidak mencukupi untuk transaksi ini.')->withInput();
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $product) {
            $validated['user_id'] = auth()->id();
            \App\Models\StockMovement::create($validated);

            if ($validated['type'] === 'in') {
                $product->increment('stock', $validated['quantity']);
            } else {
                $product->decrement('stock', $validated['quantity']);
            }
        });

        return redirect()->route('products.index')->with('success', 'Transaksi stok berhasil.');
    }
}
