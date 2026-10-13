<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:masuk,keluar',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->type === 'keluar' && $product->stock < $request->quantity) {
            return redirect()->route('dashboard', ['tab' => 'transactions'])->with('error', 'Stok tidak mencukupi untuk pengeluaran sejumlah ' . $request->quantity);
        }

        Transaction::create($request->all());

        if ($request->type === 'masuk') {
            $product->stock += $request->quantity;
        } else {
            $product->stock -= $request->quantity;
        }
        $product->save();

        return redirect()->route('dashboard', ['tab' => 'transactions'])->with('success', 'Transaksi berhasil dicatat.');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $product = Product::find($transaction->product_id);

        if ($product) {
            if ($transaction->type === 'masuk') {
                $product->stock -= $transaction->quantity;
            } else {
                $product->stock += $transaction->quantity;
            }
            $product->save();
        }

        $transaction->delete();

        return redirect()->route('dashboard', ['tab' => 'transactions'])->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan.');
    }
}