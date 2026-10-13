<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manajer - Stockify Inventory</title>
    <!-- Tailwind CSS & Flowbite CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-amber-50/40 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigasi Utama (Nuansa Cokelat Kayu / Espresso) -->
        <aside class="w-64 bg-[#2C221E] text-amber-100 flex flex-col shadow-2xl hidden md:flex">
            <div class="p-5 text-2xl font-black tracking-wider flex items-center space-x-3 border-b border-[#3D302B]">
                <div class="bg-amber-700 p-2.5 rounded-xl text-white shadow-lg shadow-amber-900/50">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <span class="bg-gradient-to-r from-amber-200 via-orange-300 to-amber-500 bg-clip-text text-transparent">STOCKIFY</span>
            </div>
            
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-amber-700 text-white font-medium shadow-md shadow-amber-900/40 transition">
                    <i class="fa-solid fa-chart-pie w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-amber-200/80 hover:bg-[#3D302B] hover:text-white transition">
                    <i class="fa-solid fa-box-archive w-5"></i>
                    <span>Data Produk</span>
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-amber-200/80 hover:bg-[#3D302B] hover:text-white transition">
                    <i class="fa-solid fa-folder-tree w-5"></i>
                    <span>Kategori</span>
                </a>
                <a href="{{ route('suppliers.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-amber-200/80 hover:bg-[#3D302B] hover:text-white transition">
                    <i class="fa-solid fa-truck-field w-5"></i>
                    <span>Supplier</span>
                </a>
                <a href="{{ route('transactions.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-amber-200/80 hover:bg-[#3D302B] hover:text-white transition">
                    <i class="fa-solid fa-right-left w-5"></i>
                    <span>Transaksi Stok</span>
                </a>
                <a href="{{ route('reports.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-amber-200/80 hover:bg-[#3D302B] hover:text-white transition">
                    <i class="fa-solid fa-file-invoice-dollar w-5"></i>
                    <span>Laporan & Ekspor</span>
                </a>
            </nav>

            <div class="p-4 border-t border-[#3D302B]">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 bg-stone-800 hover:bg-rose-900/50 text-rose-300 hover:text-rose-100 px-4 py-2.5 rounded-xl font-medium transition border border-rose-900/30">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            
            <!-- Top Bar Navbar -->
            <header class="bg-white/80 backdrop-blur-md shadow-sm px-6 py-4 flex justify-between items-center border-b border-amber-100">
                <div class="flex items-center space-x-3">
                    <h1 class="text-xl font-extrabold text-stone-800">Panel Manajer Gudang</h1>
                    <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-amber-200">Sistem Aktif</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-bold text-stone-700">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <p class="text-xs text-amber-700 font-medium">Manajer Utama</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-amber-800 text-amber-100 flex items-center justify-center font-bold text-lg shadow-md border-2 border-amber-200">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="p-6 md:p-8 space-y-8">
                
                <!-- Welcome Banner (Nuansa Cokelat Kopi / Hangat) -->
                <div class="bg-gradient-to-r from-[#4A3525] via-[#5C4033] to-[#7B5B44] rounded-3xl p-6 md:p-8 text-amber-50 shadow-xl shadow-stone-900/10 flex flex-col md:flex-row justify-between items-center relative overflow-hidden border border-[#6B4F3A]">
                    <div class="relative z-10 space-y-2">
                        <span class="bg-amber-900/60 text-amber-200 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider border border-amber-600/30">Pusat Kendali Inventaris</span>
                        <h2 class="text-2xl md:text-3xl font-extrabold">Selamat Datang, {{ auth()->user()->name ?? 'Manajer' }}! ☕</h2>
                        <p class="text-amber-100/90 text-sm max-w-xl">Kelola persediaan barang, pantau mutasi stok masuk dan keluar, serta unduh laporan berkala dengan mudah dan akurat.</p>
                    </div>
                    <div class="mt-6 md:mt-0 flex space-x-3 relative z-10">
                        <a href="{{ route('products.index') }}" class="bg-amber-100 text-amber-950 hover:bg-white font-bold px-5 py-3 rounded-2xl shadow-lg transition flex items-center space-x-2">
                            <i class="fa-solid fa-circle-plus text-amber-800"></i>
                            <span>Kelola Produk</span>
                        </a>
                        <a href="{{ route('reports.index') }}" class="bg-[#3A281C]/80 hover:bg-[#3A281C] text-amber-100 font-semibold px-5 py-3 rounded-2xl border border-amber-500/30 backdrop-blur-md transition flex items-center space-x-2">
                            <i class="fa-solid fa-file-lines text-amber-400"></i>
                            <span>Cetak Laporan</span>
                        </a>
                    </div>
                    <!-- Background Decoration Circles -->
                    <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-amber-500/10 rounded-full blur-3xl"></div>
                </div>

                <!-- Statistics Grid Cards (Nuansa Cokelat Hangat) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1: Total Jenis Produk -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-amber-100 hover:shadow-md transition flex items-center space-x-4">
                        <div class="bg-amber-50 text-amber-800 p-4 rounded-2xl text-xl border border-amber-200">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-stone-400 uppercase tracking-wider">Total Jenis Produk</p>
                            <h3 class="text-2xl font-black text-stone-800 mt-1">{{ count($products) }} <span class="text-sm font-normal text-stone-500">Item</span></h3>
                        </div>
                    </div>

                    <!-- Card 2: Total Unit Stok -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-amber-100 hover:shadow-md transition flex items-center space-x-4">
                        <div class="bg-orange-50 text-orange-800 p-4 rounded-2xl text-xl border border-orange-200">
                            <i class="fa-solid fa-cubes-stacked"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-stone-400 uppercase tracking-wider">Total Unit Stok</p>
                            <h3 class="text-2xl font-black text-stone-800 mt-1">{{ $products->sum('stock') ?? 0 }} <span class="text-sm font-normal text-stone-500">Unit</span></h3>
                        </div>
                    </div>

                    <!-- Card 3: Kategori Produk -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-amber-100 hover:shadow-md transition flex items-center space-x-4">
                        <div class="bg-yellow-50 text-yellow-800 p-4 rounded-2xl text-xl border border-yellow-200">
                            <i class="fa-solid fa-tags"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-stone-400 uppercase tracking-wider">Kategori Barang</p>
                            <h3 class="text-2xl font-black text-stone-800 mt-1">{{ count($categories) }} <span class="text-sm font-normal text-stone-500">Kategori</span></h3>
                        </div>
                    </div>

                    <!-- Card 4: Stok Menipis -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-amber-100 hover:shadow-md transition flex items-center space-x-4">
                        <div class="bg-amber-100 text-amber-900 p-4 rounded-2xl text-xl border border-amber-300">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-stone-400 uppercase tracking-wider">Stok Menipis (< 5)</p>
                            <h3 class="text-2xl font-black text-amber-800 mt-1">{{ $products->where('stock', '<', 5)->count() }} <span class="text-sm font-normal text-stone-500">Produk</span></h3>
                        </div>
                    </div>
                </div>

                <!-- Quick Action Shortcuts (Fitur Utama dengan Nuansa Cokelat) -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Fitur 1: Kelola Produk -->
                    <a href="{{ route('products.index') }}" class="bg-white p-5 rounded-3xl border border-amber-100 hover:border-amber-700 hover:shadow-lg transition flex flex-col items-center text-center group">
                        <div class="bg-amber-50 group-hover:bg-amber-800 group-hover:text-white text-amber-800 p-4 rounded-2xl text-xl mb-3 transition shadow-sm">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <span class="font-bold text-stone-800 text-sm">Kelola Produk</span>
                        <span class="text-xs text-stone-400 mt-1 leading-relaxed">Tambah, edit spesifikasi & harga barang</span>
                    </a>
                    
                    <!-- Fitur 2: Kategori Barang -->
                    <a href="{{ route('categories.index') }}" class="bg-white p-5 rounded-3xl border border-amber-100 hover:border-orange-700 hover:shadow-lg transition flex flex-col items-center text-center group">
                        <div class="bg-orange-50 group-hover:bg-orange-800 group-hover:text-white text-orange-800 p-4 rounded-2xl text-xl mb-3 transition shadow-sm">
                            <i class="fa-solid fa-folder-tree"></i>
                        </div>
                        <span class="font-bold text-stone-800 text-sm">Kategori Barang</span>
                        <span class="text-xs text-stone-400 mt-1 leading-relaxed">Pengelompokan jenis & departemen stok</span>
                    </a>

                    <!-- Fitur 3: Data Supplier -->
                    <a href="{{ route('suppliers.index') }}" class="bg-white p-5 rounded-3xl border border-amber-100 hover:border-yellow-700 hover:shadow-lg transition flex flex-col items-center text-center group">
                        <div class="bg-yellow-50 group-hover:bg-yellow-800 group-hover:text-white text-yellow-800 p-4 rounded-2xl text-xl mb-3 transition shadow-sm">
                            <i class="fa-solid fa-handshake-angle"></i>
                        </div>
                        <span class="font-bold text-stone-800 text-sm">Data Supplier</span>
                        <span class="text-xs text-stone-400 mt-1 leading-relaxed">Direktori vendor & mitra pemasok barang</span>
                    </a>

                    <!-- Fitur 4: Transaksi Stok -->
                    <a href="{{ route('transactions.index') }}" class="bg-white p-5 rounded-3xl border border-amber-100 hover:border-[#5C4033] hover:shadow-lg transition flex flex-col items-center text-center group">
                        <div class="bg-stone-100 group-hover:bg-[#5C4033] group-hover:text-white text-[#5C4033] p-4 rounded-2xl text-xl mb-3 transition shadow-sm">
                            <i class="fa-solid fa-right-left"></i>
                        </div>
                        <span class="font-bold text-stone-800 text-sm">Transaksi Stok</span>
                        <span class="text-xs text-stone-400 mt-1 leading-relaxed">Catat barang masuk & keluar gudang</span>
                    </a>
                </div>

                <!-- Monitoring Stok Tabel Real-time -->
                <div class="bg-white rounded-3xl shadow-sm border border-amber-100 overflow-hidden">
                    <div class="p-6 border-b border-amber-100 flex justify-between items-center bg-amber-50/50">
                        <div>
                            <h3 class="text-lg font-bold text-stone-800">Monitoring Stok Produk Real-time</h3>
                            <p class="text-xs text-stone-400">Daftar produk terbaru yang terdaftar dalam inventaris gudang.</p>
                        </div>
                        <a href="{{ route('products.index') }}" class="text-amber-800 hover:text-amber-950 text-sm font-bold flex items-center space-x-1">
                            <span>Lihat Semua</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-amber-100/60 text-stone-600 uppercase text-xs tracking-wider border-b border-amber-100">
                                    <th class="py-4 px-6 font-bold">Kode SKU</th>
                                    <th class="py-4 px-6 font-bold">Nama Produk</th>
                                    <th class="py-4 px-6 font-bold">Jumlah Stok</th>
                                    <th class="py-4 px-6 font-bold">Status Ketersediaan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-amber-50 text-sm text-stone-600">
                                @forelse($products as $product)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="py-4 px-6 font-mono font-bold text-amber-900">{{ $product->code ?? 'PRD-00' . $loop->iteration }}</td>
                                    <td class="py-4 px-6 font-bold text-stone-800">{{ $product->name }}</td>
                                    <td class="py-4 px-6 font-bold text-stone-700">{{ $product->stock }} Unit</td>
                                    <td class="py-4 px-6">
                                        @if($product->stock > 5)
                                            <span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full inline-flex items-center space-x-1 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                <span>Aman</span>
                                            </span>
                                        @else
                                            <span class="bg-amber-100 text-amber-900 text-xs font-semibold px-3 py-1 rounded-full inline-flex items-center space-x-1 border border-amber-300">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-700"></span>
                                                <span>Menipis</span>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-stone-400">Belum ada data produk tersimpan di database.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body>
</html>