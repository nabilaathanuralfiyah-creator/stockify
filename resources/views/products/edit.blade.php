<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockify Enterprise - Dashboard Interaktif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen p-6 font-sans">

    <!-- Header Navigation -->
    <div class="flex justify-between items-center mb-8 bg-slate-800 p-4 rounded-xl border border-slate-700 shadow-lg">
        <div>
            <h1 class="text-2xl font-bold text-indigo-400">Stockify <span class="text-xs bg-indigo-600 text-white px-2 py-1 rounded-full">PRO</span></h1>
            <p class="text-xs text-slate-400">Sistem Manajemen Stok & Inventaris Gudang</p>
        </div>
        <div class="flex gap-3 items-center">
            <span class="text-sm font-medium bg-slate-700 px-3 py-1.5 rounded-lg border border-slate-600">
                👤 {{ Auth::user()->name ?? 'Admin' }}
            </span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-sm px-4 py-1.5 rounded-lg font-medium transition">Keluar</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/20 border border-emerald-500 text-emerald-300 p-4 rounded-xl mb-6 flex items-center gap-3">
            ✅ <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-slate-800 p-5 rounded-xl border border-slate-700">
            <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Total Jenis Produk</p>
            <h3 class="text-2xl font-bold text-slate-100">{{ $totalItems }} <span class="text-sm font-normal text-slate-400">Item</span></h3>
        </div>
        <div class="bg-slate-800 p-5 rounded-xl border border-slate-700">
            <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Total Stok Fisik</p>
            <h3 class="text-2xl font-bold text-indigo-400">{{ $totalStock }} <span class="text-sm font-normal text-slate-400">Unit</span></h3>
        </div>
        <div class="bg-slate-800 p-5 rounded-xl border border-slate-700">
            <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Nilai Aset Inventaris</p>
            <h3 class="text-2xl font-bold text-emerald-400">Rp {{ number_format($totalAssetValue, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-slate-800 p-5 rounded-xl border border-slate-700">
            <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Peringatan Stok Menipis</p>
            <h3 class="text-2xl font-bold text-amber-400">{{ $lowStockCount }} <span class="text-sm font-normal text-slate-400">Produk</span></h3>
        </div>
    </div>

    <!-- Interactive Forms Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Form Tambah Produk -->
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
            <h2 class="text-lg font-bold text-slate-200 mb-4 flex items-center gap-2">📦 Tambah Produk Baru</h2>
            <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Kode Produk</label>
                        <input type="text" name="code" required placeholder="PRD-001" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Nama Produk</label>
                        <input type="text" name="name" required placeholder="Laptop Gaming" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Kategori</label>
                        <select name="category_id" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Supplier</label>
                        <select name="supplier_id" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Stok Awal</label>
                        <input type="number" name="stock" value="0" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Stok Min (Alert)</label>
                        <input type="number" name="min_stock" value="5" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Harga Satuan (Rp)</label>
                        <input type="number" name="unit_price" value="0" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Lokasi Rak</label>
                        <input type="text" name="rack_location" placeholder="Rak A1" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">No. Batch / Serial</label>
                        <input type="text" name="batch_number" placeholder="BATCH-2026" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Tgl Kadaluarsa</label>
                        <input type="date" name="expired_date" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                    </div>
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition shadow-md">
                    + Simpan Produk Baru
                </button>
            </form>
        </div>

        <!-- Form Mutasi Stok & Stock Opname -->
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
            <h2 class="text-lg font-bold text-slate-200 mb-4 flex items-center gap-2">🔄 Catat Mutasi / Stock Opname</h2>
            <form action="{{ route('products.mutate') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Pilih Produk</label>
                    <select name="product_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->code }} - {{ $p->name }} (Stok saat ini: {{ $p->stock }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Jenis Transaksi</label>
                        <select name="type" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                            <option value="in">🟢 Barang Masuk (Restok)</option>
                            <option value="out">🔴 Barang Keluar</option>
                            <option value="adjustment">⚙️ Stock Opname (Penyesuaian)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Jumlah / Stok Baru</label>
                        <input type="number" name="qty" min="1" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Keterangan / Catatan</label>
                    <textarea name="notes" rows="3" placeholder="Restok supplier / Selisih opname gudang..." class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none"></textarea>
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 rounded-lg transition shadow-md">
                    💾 Simpan Transaksi Mutasi
                </button>
            </form>
        </div>
    </div>

    <!-- Inventaris Table Section -->
    <div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden shadow-lg">
        <div class="p-5 border-b border-slate-700 flex justify-between items-center">
            <h2 class="text-lg font-bold text-slate-200">📋 Daftar Inventaris Barang</h2>
            <span class="text-xs bg-slate-700 px-3 py-1 rounded-full text-slate-300">Total: {{ $products->count() }} Item</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-900/50 text-slate-400 uppercase text-xs font-semibold border-b border-slate-700">
                    <tr>
                        <th class="p-4">Kode</th>
                        <th class="p-4">Nama Produk</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Lokasi Rak</th>
                        <th class="p-4">Harga Satuan</th>
                        <th class="p-4">Stok Available</th>
                        <th class="p-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse($products as $prod)
                        <tr class="hover:bg-slate-700/30 transition">
                            <td class="p-4 font-mono text-indigo-400 font-bold">{{ $prod->code }}</td>
                            <td class="p-4 font-medium text-slate-100">{{ $prod->name }}</td>
                            <td class="p-4"><span class="bg-slate-700 text-slate-300 px-2 py-1 rounded text-xs">{{ $prod->category->name ?? '-' }}</span></td>
                            <td class="p-4 text-slate-400">{{ $prod->rack_location ?? '-' }}</td>
                            <td class="p-4">Rp {{ number_format($prod->unit_price, 0, ',', '.') }}</td>
                            <td class="p-4 font-bold {{ $prod->stock <= $prod->min_stock ? 'text-amber-400' : 'text-emerald-400' }}">
                                {{ $prod->stock }} pcs
                            </td>
                            <td class="p-4">
                                @if($prod->stock <= $prod->min_stock)
                                    <span class="bg-amber-500/20 text-amber-300 border border-amber-500/30 px-2.5 py-1 rounded-full text-xs font-semibold">Stok Menipis</span>
                                @else
                                    <span class="bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-2.5 py-1 rounded-full text-xs font-semibold">Aman</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-slate-500">Belum ada data barang yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>