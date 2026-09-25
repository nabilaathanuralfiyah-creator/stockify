<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockOpnameController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('stock_opname.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'physical_stock' => 'required|integer|min:0',
            'notes'        => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::findOrFail($validated['product_id']);
            $difference = $validated['physical_stock'] - $product->stock;

            if ($difference != 0) {
                $type = $difference > 0 ? 'in' : 'out';
                $quantity = abs($difference);

                StockTransaction::create([
                    'product_id' => $product->id,
                    'type'       => $type,
                    'quantity'   => $quantity,
                    'notes'      => 'Stock Opname: ' . $validated['notes'],
                ]);

                $product->stock = $validated['physical_stock'];
                $product->save();
            }
        });

        return redirect()->back()->with('success', 'Stock Opname berhasil diproses!');
    }
}
