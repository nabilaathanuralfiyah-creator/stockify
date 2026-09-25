<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $transactions = StockTransaction::with('product')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->latest()
            ->get();

        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')->get();

        return view('reports.index', compact('transactions', 'startDate', 'endDate', 'lowStockProducts'));
    }
}
