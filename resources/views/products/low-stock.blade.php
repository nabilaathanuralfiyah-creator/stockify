<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Menipis - Stockify</title>
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
                <a href="{{ route('transactions.index') }}" class="block px-4 py-2.5 rounded-lg text-amber-100 hover:bg-amber-800 transition">
                    Transaksi Stok
                </a>
                <a href="{{ route('low-stock') }}" class="block px-4 py-2.5 rounded-lg bg-amber-950 text-white font-semibold transition">
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
                    Peringatan Stok Menipis
                </h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Admin Stockify' }}</span>
                    <span class="bg-amber-800 text-white text-xs px-2.5 py-1 rounded-full font-bold">ROLE: ADMIN</span>
                </div>
            </header>

            <!-- Isi Halaman / Konten -->
            <main class="flex-1 py-10 px-8 overflow-y-auto">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Produk dengan Stok Terbatas</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa Stok</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($products as $index => $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $product->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $product->category->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600">
                                            {{ $product->stock }} Unit (Menipis!)
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Aman! Tidak ada produk dengan stok menipis.</td>
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