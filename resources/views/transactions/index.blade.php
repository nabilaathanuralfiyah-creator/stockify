<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Stok - Stockify</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex">
        <!-- SIDEBAR KIRI -->
        <aside class="w-64 bg-[#78350f] text-white flex flex-col min-h-screen shadow-md fixed inset-y-0 left-0">
            <!-- Brand / Logo -->
            <div class="p-6 flex items-center space-x-3 border-b border-amber-800">
                <span class="text-2xl font-bold tracking-wider">📦 STOCKIFY</span>
            </div>

            <!-- Menu Navigasi Samping -->
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-lg text-amber-100 hover:bg-amber-800 transition">
                    Dashboard
                </a>
                <a href="{{ route('products.index') }}" class="block px-4 py-2.5 rounded-lg text-amber-100 hover:bg-amber-800 transition">
                    Produk
                </a>
                <a href="{{ route('categories.index') }}" class="block px-4 py-2.5 rounded-lg text-amber-100 hover:bg-amber-800 transition">
                    Kategori
                </a>
                <a href="{{ route('suppliers.index') }}" class="block px-4 py-2.5 rounded-lg text-amber-100 hover:bg-amber-800 transition">
                    Supplier
                </a>
                <a href="{{ route('users.index') }}" class="block px-4 py-2.5 rounded-lg text-amber-100 hover:bg-amber-800 transition">
                    Pengguna
                </a>
                
                <div class="pt-4 pb-2 text-xs font-semibold text-amber-300 uppercase tracking-wider px-4">Operasional</div>
                <a href="{{ route('transactions.index') }}" class="block px-4 py-2.5 rounded-lg bg-amber-950 text-white font-semibold transition">
                    Transaksi Stok
                </a>
                <a href="{{ route('products.low-stock') }}" class="block px-4 py-2.5 rounded-lg text-amber-100 hover:bg-amber-800 transition">
                    Stok Menipis
                </a>

                <div class="pt-4 pb-2 text-xs font-semibold text-amber-300 uppercase tracking-wider px-4">Analisis & Pengaturan</div>
                <a href="{{ route('reports.index') }}" class="block px-4 py-2.5 rounded-lg text-amber-100 hover:bg-amber-800 transition">
                    Laporan Stok
                </a>
                <a href="{{ route('settings.index') }}" class="block px-4 py-2.5 rounded-lg text-amber-100 hover:bg-amber-800 transition">
                    Pengaturan Gudang
                </a>
            </nav>

            <!-- Tombol Keluar Akun -->
            <div class="p-4 border-t border-amber-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-amber-950 hover:bg-black text-white text-center py-2 px-4 rounded-lg font-medium transition">
                        Keluar Akun
                    </button>
                </form>
            </div>
        </aside>

        <!-- KONTEN UTAMA DI SEBELAH KANAN -->
        <div class="flex-1 flex flex-col min-w-0 ml-64">
            <!-- Header Atas -->
            <header class="bg-white shadow flex justify-between items-center py-4 px-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Transaksi Stok
                </h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Admin Stockify' }}</span>
                    <span class="bg-amber-800 text-white text-xs px-2.5 py-1 rounded-full font-bold">ROLE: ADMIN</span>
                </div>
            </header>

            <!-- Isi Halaman / Konten -->
            <main class="flex-1 py-10 px-8 overflow-y-auto">
                
                <!-- Notifikasi Sukses -->
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Notifikasi Error -->
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Form Catat Transaksi Baru -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6 p-6 border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Catat Transaksi Baru</h3>
                    
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <!-- Pilih Produk -->
                            <div class="mb-4">
                                <label for="product_id" class="block text-sm font-medium text-gray-700">Pilih Produk</label>
                                <select name="product_id" id="product_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} (Stok: {{ $product->stock }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Jenis Transaksi -->
                            <div class="mb-4">
                                <label for="type" class="block text-sm font-medium text-gray-700">Jenis Transaksi</label>
                                <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2" required>
                                    <option value="masuk">Stok Masuk (+)</option>
                                    <option value="keluar">Stok Keluar (-)</option>
                                </select>
                            </div>

                            <!-- Jumlah Unit -->
                            <div class="mb-4">
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah Unit</label>
                                <input type="number" name="quantity" id="quantity" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2" placeholder="Masukkan jumlah" required>
                            </div>

                            <!-- Keterangan / Catatan -->
                            <div class="mb-4">
                                <label for="note" class="block text-sm font-medium text-gray-700">Keterangan / Catatan</label>
                                <input type="text" name="note" id="note" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2" placeholder="Contoh: Pembelian restok baru">
                            </div>

                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit" class="bg-amber-700 hover:bg-amber-800 text-white font-bold py-2 px-4 rounded shadow transition">
                                Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tabel Riwayat Transaksi Stok -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Transaksi Stok</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($transactions as $index => $trx)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $trx->product->name ?? 'Produk Dihapus' }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if(strtolower(trim($trx->type)) === 'masuk')
                                                <span class="px-2.5 py-1 text-green-700 bg-green-100 rounded-full text-xs font-semibold">Masuk (+)</span>
                                            @else
                                                <span class="px-2.5 py-1 text-red-700 bg-red-100 rounded-full text-xs font-semibold">Keluar (-)</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $trx->quantity }} Unit</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $trx->note ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Stok produk akan dikembalikan.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada riwayat transaksi.</td>
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