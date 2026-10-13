<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Mengirimkan variabel products ke view laporan
        $products = Product::with('category')->latest()->get();
        return view('reports.index', compact('products'));
    }
}