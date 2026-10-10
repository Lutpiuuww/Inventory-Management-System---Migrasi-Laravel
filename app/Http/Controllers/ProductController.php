<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Product::with('category');

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($category_id = $request->input('category_id')) {
            $query->where('category_id', $category_id);
        }

        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');
        
        $allowedSorts = ['id', 'sku', 'name', 'price', 'stock'];
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $order === 'desc' ? 'desc' : 'asc');
        }

        $products = $query->paginate(6)->withQueryString();
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        $suppliers = \App\Models\Supplier::orderBy('name')->get();
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|string|max:50|unique:products',
            'name' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'suppliers' => 'nullable|array',
            'suppliers.*' => 'exists:suppliers,id',
        ]);

        $productData = \Illuminate\Support\Arr::except($validated, ['suppliers', 'image']);
        $productData['stock'] = 0;

        if ($request->hasFile('image')) {
            $productData['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product = \App\Models\Product::create($productData);

        if (!empty($validated['suppliers'])) {
            $product->suppliers()->attach($validated['suppliers']);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(\App\Models\Product $product)
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        $suppliers = \App\Models\Supplier::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, \App\Models\Product $product)
    {
        $validated = $request->validate([
            'sku' => 'required|string|max:50|unique:products,sku,'.$product->id,
            'name' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'suppliers' => 'nullable|array',
            'suppliers.*' => 'exists:suppliers,id',
        ]);

        $productData = \Illuminate\Support\Arr::except($validated, ['suppliers', 'image']);

        if ($request->hasFile('image')) {
            if ($product->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_path);
            }
            $productData['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($productData);

        if (isset($validated['suppliers'])) {
            $product->suppliers()->sync($validated['suppliers']);
        } else {
            $product->suppliers()->detach();
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(\App\Models\Product $product)
    {
        if ($product->stockMovements()->count() > 0) {
            return redirect()->route('products.index')->with('error', 'Gagal menghapus: Produk ini memiliki histori transaksi.');
        }

        if ($product->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
