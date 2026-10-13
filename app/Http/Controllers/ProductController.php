<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    // Tampilan Khusus Fitur Stok Menipis
    public function lowStock()
    {
        $products = Product::with('category')->where('stock', '<=', 5)->get();
        return view('products.low-stock', compact('products'));
    }
}