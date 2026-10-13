<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('supplier', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Data supplier berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus!');
    }
}