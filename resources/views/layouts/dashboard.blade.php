@extends('layouts.app')

@section('content')
@php
    $totalProducts = \App\Models\Product::count();
    $lowStock = \App\Models\Product::whereColumn('stock', '<=', 'minimum_stock')->count();
    $totalTransactions = \App\Models\Transaction::count();
    $totalSuppliers = \App\Models\Supplier::count();
@endphp

<div class="mb-8">
    <h1 class="text-3xl font-extxl font-extrabold text-slate-900 dark:text-white tracking-tight">Dashboard Utama</h1>
    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Selamat datang kembali! Berikut ringkasan performa gudang hari ini.</p>
</div>

@if($lowStock > 0)
<div class="flex items-center justify-between p-5 mb-8 text-amber-800 border border-amber-200 rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50 dark:bg-slate-800 dark:text-amber-300 dark:border-amber-900 shadow-sm">
    <div class="flex items-center gap-3">
        <div class="p-3 bg-amber-500 text-white rounded-xl shadow-md">⚠️</div>
        <div>
            <span class="font-bold block text-base">Peringatan Stok Kritis!</span>
            <span class="text-sm">Terdapat <strong>{{ $lowStock }} produk</strong> yang sudah menipis atau habis di bawah batas minimum.</span>
        </div>
    </div>
    <a href="{{ route('products.index') }}" class="px-4 py-2 text-xs font-bold text-white bg-amber-600 rounded-xl hover:bg-amber-700 shadow-md">Cek Produk</a>
</div>
@endif

<!-- Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1 -->
    <div class="p-6 bg-gradient-to-br from-indigo-500 to-blue-600 text-white rounded-3xl shadow-xl shadow-indigo-500/25 relative overflow-hidden">
        <div class="absolute -right-4 -bottom-4 text-white/10 text-8xl font-black">📦</div>
        <p class="text-xs font-bold uppercase tracking-wider text-indigo-100">Total Produk</p>
        <h3 class="text-4xl font-extrabold mt-3">{{ $totalProducts }}</h3>
        <p class="text-xs text-indigo-100 mt-2">Item terdaftar di sistem</p>
    </div>
    <!-- Card 2 -->
    <div class="p-6 bg-gradient-to-br from-rose-500 to-red-600 text-white rounded-3xl shadow-xl shadow-rose-500/25 relative overflow-hidden">
        <div class="absolute -right-4 -bottom-4 text-white/10 text-8xl font-black">⚠️</div>
        <p class="text-xs font-bold uppercase tracking-wider text-rose-100">Stok Menipis</p>
        <h3 class="text-4xl font-extrabold mt-3">{{ $lowStock }}</h3>
        <p class="text-xs text-rose-100 mt-2">Perlu segera restock</p>
    </div>
    <!-- Card 3 -->
    <div class="p-6 bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-3xl shadow-xl shadow-emerald-500/25 relative overflow-hidden">
        <div class="absolute -right-4 -bottom-4 text-white/10 text-8xl font-black">🔄</div>
        <p class="text-xs font-bold uppercase tracking-wider text-emerald-100">Total Transaksi</p>
        <h3 class="text-4xl font-extrabold mt-3">{{ $totalTransactions }}</h3>
        <p class="text-xs text-emerald-100 mt-2">Barang masuk & keluar</p>
    </div>
    <!-- Card 4 -->
    <div class="p-6 bg-gradient-to-br from-violet-500 to-purple-600 text-white rounded-3xl shadow-xl shadow-violet-500/25 relative overflow-hidden">
        <div class="absolute -right-4 -bottom-4 text-white/10 text-8xl font-black">🏭</div>
        <p class="text-xs font-bold uppercase tracking-wider text-violet-100">Total Supplier</p>
        <h3 class="text-4xl font-extrabold mt-3">{{ $totalSuppliers }}</h3>
        <p class="text-xs text-violet-100 mt-2">Mitra pemasok aktif</p>
    </div>
</div>
@endsection