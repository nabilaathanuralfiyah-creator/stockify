<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - Stockify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-amber-50/40 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Berkelompok Profesional -->
        <aside class="w-64 bg-[#2C221E] text-amber-100 flex flex-col shadow-2xl hidden md:flex">
            <div class="p-5 text-2xl font-black tracking-wider flex items-center space-x-3 border-b border-[#3D302B]">
                <div class="bg-amber-700 p-2.5 rounded-xl text-white shadow-lg">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <span class="bg-gradient-to-r from-amber-200 via-orange-300 to-amber-500 bg-clip-text text-transparent">STOCKIFY</span>
            </div>
            
            <nav class="flex-1 p-4 space-y-4 overflow-y-auto text-xs">
                
                <!-- WORKSPACE -->
                <div class="space-y-1">
                    <p class="px-4 text-[10px] font-bold text-amber-400 uppercase tracking-wider">Workspace</p>
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-amber-200/80 hover:bg-[#3D302B] hover:text-white transition text-sm">
                        <i class="fa-solid fa-chart-pie w-5"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <!-- MASTER DATA -->
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                <div class="space-y-1">
                    <p class="px-4 text-[10px] font-bold text-amber-400 uppercase tracking-wider">Master Data</p>
                    <a href="{{ route('products.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl bg-amber-700 text-white font-medium shadow-md transition text-sm">
                        <i class="fa-solid fa-box-archive w-5"></i>
                        <span>Produk</span>
                    </a>
                    <a href="{{ route('categories.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-amber-200/80 hover:bg-[#3D302B] hover:text-white transition text-sm">
                        <i class="fa-solid fa-folder-tree w-5"></i>
                        <span>Kategori</span>
                    </a>
                    <a href="{{ route('suppliers.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-amber-200/80 hover:bg-[#3D302B] hover:text-white transition text-sm">
                        <i class="fa-solid fa-truck-field w-5"></i>
                        <span>Supplier</span>
                    </a>
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('users.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-amber-200/80 hover:bg-[#3D302B] hover:text-white transition text-sm">
                        <i class="fa-solid fa-users-gear w-5"></i>
                        <span>Pengguna</span>
                    </a>
                    @endif
                </div>
                @endif

                <!-- OPERASIONAL -->
                <div class="space-y-1">
                    <p class="px-4 text-[10px] font-bold text-amber-400 uppercase tracking-wider">Operasional</p>
                    <a href="{{ route('transactions.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-amber-200/80 hover:bg-[#3D302B] hover:text-white transition text-sm">
                        <i class="fa-solid fa-right-left w-5"></i>
                        <span>Transaksi Stok</span>
                    </a>
                    <a href="{{ route('products.low-stock') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-amber-200/80 hover:bg-[#3D302B] hover:text-white transition text-sm">
                        <i class="fa-solid fa-triangle-exclamation w-5"></i>
                        <span>Stok Menipis</span>
                    </a>
                </div>

                <!-- ANALISIS & PENGATURAN -->
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                <div class="space-y-1">
                    <p class="px-4 text-[10px] font-bold text-amber-400 uppercase tracking-wider">Analisis & Pengaturan</p>
                    <a href="{{ route('reports.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-amber-200/80 hover:bg-[#3D302B] hover:text-white transition text-sm">
                        <i class="fa-solid fa-file-invoice-dollar w-5"></i>
                        <span>Laporan Stok</span>
                    </a>
                    <a href="{{ route('settings.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-amber-200/80 hover:bg-[#3D302B] hover:text-white transition text-sm">
                        <i class="fa-solid fa-gears w-5"></i>
                        <span>Pengaturan Gudang</span>
                    </a>
                </div>
                @endif

            </nav>

            <div class="p-4 border-t border-[#3D302B]">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 bg-rose-900/40 hover:bg-rose-900 text-rose-200 px-4 py-2.5 rounded-xl font-medium transition border border-rose-700/30 text-xs">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            
            <header class="bg-white/80 backdrop-blur-md shadow-sm px-6 py-4 flex justify-between items-center border-b border-amber-100">
                <div class="flex items-center space-x-3">
                    <div class="bg-amber-700 text-white p-2 rounded-xl shadow">
                        <i class="fa-solid fa-box-archive"></i>
                    </div>
                    <h1 class="text-xl font-extrabold text-stone-800">Data Produk</h1>
                    <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-amber-200">Modul Inventaris</span>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-xs font-bold text-stone-800">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-stone-400 uppercase tracking-wider font-semibold">{{ auth()->user()->email }}</p>
                    </div>
                    <span class="bg-amber-800 text-white text-xs font-black px-3 py-1.5 rounded-xl uppercase tracking-wider shadow-sm">
                        Role: {{ auth()->user()->role }}
                    </span>
                </div>
            </header>

            <main class="p-6 md:p-8 space-y-6">
                
                @if(session('success'))
                    <div class="p-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center space-x-2">
                        <i class="fa-solid fa-circle-check text-lg"></i>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Form Produk -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-amber-100 space-y-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-bold text-stone-800">
                                @isset($product) Edit Data Produk @else Tambah Produk Baru @endif
                            </h2>
                            <p class="text-xs text-stone-400">Silakan isi formulir di bawah ini untuk mengelola data inventaris produk.</p>
                        </div>
                        @isset($product)
                            <a href="{{ route('products.index') }}" class="text-xs font-bold text-amber-700 hover:underline">Batal Edit</a>
                        @endisset
                    </div>

                    <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST" class="space-y-4">
                        @csrf
                        @isset($product)
                            @method('PUT')
                        @endisset

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-stone-600 uppercase mb-1">Nama Produk</label>
                                <input type="text" name="name" value="{{ $product->name ?? '' }}" required placeholder="Contoh: Laptop Asus" class="w-full bg-amber-50/40 border border-amber-200 rounded-2xl px-4 py-3 text-sm focus:ring-amber-700 focus:border-amber-700">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-stone-600 uppercase mb-1">Kategori</label>
                                <select name="category_id" required class="w-full bg-amber-50/40 border border-amber-200 rounded-2xl px-4 py-3 text-sm focus:ring-amber-700 focus:border-amber-700">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" {{ (isset($product) && $product->category_id == $c->id) ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-stone-600 uppercase mb-1">Stok Awal</label>
                                <input type="number" name="stock" value="{{ $product->stock ?? '' }}" required min="0" placeholder="0" class="w-full bg-amber-50/40 border border-amber-200 rounded-2xl px-4 py-3 text-sm focus:ring-amber-700 focus:border-amber-700">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-stone-600 uppercase mb-1">Harga Satuan (Rp)</label>
                                <input type="number" name="price" value="{{ $product->price ?? '' }}" required min="0" placeholder="0" class="w-full bg-amber-50/40 border border-amber-200 rounded-2xl px-4 py-3 text-sm focus:ring-amber-700 focus:border-amber-700">
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="bg-amber-800 hover:bg-amber-900 text-white font-bold py-3 px-6 rounded-2xl shadow-md transition text-sm flex items-center space-x-2">
                                <i class="fa-solid {{ isset($product) ? 'fa-pen-to-square' : 'fa-plus-circle' }}"></i>
                                <span>{{ isset($product) ? 'Perbarui Produk' : 'Simpan Produk' }}</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tabel Produk -->
                <div class="bg-white rounded-3xl shadow-sm border border-amber-100 overflow-hidden">
                    <div class="p-6 border-b border-amber-100 bg-amber-50/30">
                        <h3 class="text-lg font-bold text-stone-800">Daftar Produk</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-amber-100/60 text-stone-600 uppercase text-xs tracking-wider border-b border-amber-100">
                                    <th class="py-4 px-6 font-bold">#</th>
                                    <th class="py-4 px-6 font-bold">Nama Produk</th>
                                    <th class="py-4 px-6 font-bold">Kategori</th>
                                    <th class="py-4 px-6 font-bold">Stok</th>
                                    <th class="py-4 px-6 font-bold">Harga</th>
                                    <th class="py-4 px-6 font-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-amber-50 text-sm text-stone-600">
                                @forelse($products as $p)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="py-4 px-6 font-bold text-stone-400">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-6 font-bold text-stone-800">{{ $p->name }}</td>
                                    <td class="py-4 px-6">{{ $p->category->name ?? '-' }}</td>
                                    <td class="py-4 px-6 font-semibold text-stone-700">{{ $p->stock }} Unit</td>
                                    <td class="py-4 px-6 text-stone-600">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('products.edit', $p->id) }}" class="bg-amber-50 hover:bg-amber-100 text-amber-700 px-3 py-1.5 rounded-xl text-xs font-bold transition border border-amber-200">
                                                <i class="fa-solid fa-pen mr-1"></i> Edit
                                            </a>
                                            <form action="{{ route('products.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-3 py-1.5 rounded-xl text-xs font-bold transition border border-rose-200">
                                                    <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-stone-400">Belum ada data produk.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>
</html>