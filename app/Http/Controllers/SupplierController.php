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
        $validated = $request->validate([
            'name'    => 'required',
            'phone'   => 'nullable|string',
            'email'   => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        Supplier::create($validated);

        return redirect()->back()->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Supplier::destroy($id);
        return redirect()->back()->with('success', 'Supplier berhasil dihapus!');
    }
}
