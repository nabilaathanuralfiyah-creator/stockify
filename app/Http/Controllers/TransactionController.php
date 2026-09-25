<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:in,out',
            'quantity'   => 'required|numeric|min:1',
            'note'       => 'nullable|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['type'] === 'out' && $product->stock < $validated['quantity']) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        // Update stok fisik produk
        if ($validated['type'] === 'in') {
            $product->increment('stock', $validated['quantity']);
        } else {
            $product->decrement('stock', $validated['quantity']);
        }

        // Catat riwayat transaksi
        StockTransaction::create($validated);

        return redirect()->back()->with('success', 'Transaksi stok berhasil dicatat!');
    }
}
