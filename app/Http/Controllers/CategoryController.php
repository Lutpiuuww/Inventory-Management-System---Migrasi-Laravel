<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = \App\Models\Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories',
        ]);
        \App\Models\Category::create($validated);
        return redirect()->route('categories.index')->with('success', 'Kategori ditambahkan.');
    }

    public function edit(\App\Models\Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, \App\Models\Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,'.$category->id,
        ]);
        $category->update($validated);
        return redirect()->route('categories.index')->with('success', 'Kategori diupdate.');
    }

    public function destroy(\App\Models\Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori ini masih digunakan oleh produk.');
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori dihapus.');
    }
}
