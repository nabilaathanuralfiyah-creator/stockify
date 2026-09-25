<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockify - Dashboard Enterprise</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Stockify Enterprise</h1>
                <p class="text-sm text-gray-500">Sistem Manajemen Stok & Inventaris Gudang</p>
            </div>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('categories.index') }}" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-4 py-2.5">📂 Kelola Kategori</a>
                <a href="{{ route('suppliers.index') }}" class="text-white bg-teal-600 hover:bg-teal-700 font-medium rounded-lg text-sm px-4 py-2.5">🏢 Kelola Supplier</a>
                <a href="{{ route('reports.index') }}" class="text-white bg-amber-600 hover:bg-amber-700 font-medium rounded-lg text-sm px-4 py-2.5">📊 Laporan & Cetak</a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-blue-500">
                <p class="text-sm font-medium text-gray-500">Total Jenis Produk</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalProducts }} Item</p>
            </div>
            <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-green-500">
                <p class="text-sm font-medium text-gray-500">Total Stok Fisik</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalStock }} Unit</p>
            </div>
            <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-purple-500">
                <p class="text-sm font-medium text-gray-500">Nilai Inventaris</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalAsset, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-red-500">
                <p class="text-sm font-medium text-gray-500">Stok Menipis Alert</p>
                <p class="text-2xl font-bold text-red-600">{{ $lowStockCount }} Produk</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Tambah Produk Baru</h2>
                <form action="{{ route('products.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Produk</label>
                        <input type="text" name="code" required class="mt-1 w-full p-2.5 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="name" required class="mt-1 w-full p-2.5 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category_id" class="mt-1 w-full p-2.5 border rounded-lg">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Supplier</label>
                        <select name="supplier_id" class="mt-1 w-full p-2.5 border rounded-lg">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stok Awal</label>
                        <input type="number" name="stock" required class="mt-1 w-full p-2.5 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Batas Stok Min.</label>
                        <input type="number" name="min_stock" value="5" required class="mt-1 w-full p-2.5 border rounded-lg">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Harga Jual (Rp)</label>
                        <input type="number" name="price" required class="mt-1 w-full p-2.5 border rounded-lg">
                    </div>
                    <div class="md:col-span-2 flex justify-end">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Simpan Produk</button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Catat Mutasi Stok</h2>
                <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pilih Produk</label>
                        <select name="product_id" required class="mt-1 w-full p-2.5 border rounded-lg">
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} (Stok: {{ $p->stock }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Transaksi</label>
                        <select name="type" required class="mt-1 w-full p-2.5 border rounded-lg">
                            <option value="in">Barang Masuk (+)</option>
                            <option value="out">Barang Keluar (-)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Unit</label>
                        <input type="number" name="quantity" min="1" required class="mt-1 w-full p-2.5 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <input type="text" name="note" placeholder="Misal: Restock PT Jaya" class="mt-1 w-full p-2.5 border rounded-lg">
                    </div>
                    <button type="submit" class="w-full text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5">Proses Transaksi</button>
                </form>
            </div>
        </div>

        <!-- Section Inventaris & Pencarian -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
                <h2 class="text-xl font-semibold text-gray-700">Daftar Inventaris Produk</h2>
                <form action="{{ route('products.index') }}" method="GET" class="flex gap-2 w-full md:w-auto">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama / kode..." class="p-2 border rounded-lg text-sm w-full md:w-48">
                    <select name="category_id" class="p-2 border rounded-lg text-sm">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ $categoryId == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm">Cari</button>
                </form>
            </div>

            <div class="relative overflow-x-auto shadow-sm sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">Kode</th>
                            <th class="px-6 py-3">Nama Produk</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Supplier</th>
                            <th class="px-6 py-3">Stok</th>
                            <th class="px-6 py-3">Harga</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $product->code }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $product->name }}</td>
                                <td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-0.5 rounded">{{ $product->category->name ?? '-' }}</span></td>
                                <td class="px-6 py-4"><span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-0.5 rounded">{{ $product->supplier->name ?? '-' }}</span></td>
                                <td class="px-6 py-4">
                                    <span class="font-bold {{ $product->stock <= $product->min_stock ? 'text-red-600' : 'text-gray-800' }}">
                                        {{ $product->stock }} Unit
                                    </span>
                                    @if($product->stock <= $product->min_stock)
                                        <span class="ml-1 bg-red-100 text-red-800 text-xs font-semibold px-2 py-0.5 rounded">Menipis!</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 flex gap-3">
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b"><td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data produk ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
