<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Produk - Stockify</title>
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
                    <a href="{{ route('products.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-amber-200/80 hover:bg-[#3D302B] hover:text-white transition text-sm">
                        <i class="fa-solid fa-box-archive w-5"></i>
                        <span>Produk</span>
                    </a>
                    <a href="{{ route('categories.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl bg-amber-700 text-white font-medium shadow-md transition text-sm">
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
                        <i class="fa-solid fa-folder-tree"></i>
                    </div>
                    <h1 class="text-xl font-extrabold text-stone-800">Kategori Produk</h1>
                    <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-amber-200">Modul Klasifikasi</span>
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

                <!-- Form Kategori -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-amber-100 space-y-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-bold text-stone-800">
                                @isset($category) Edit Kategori @else Tambah Kategori Baru @endif
                            </h2>
                            <p class="text-xs text-stone-400">Silakan masukkan nama kelompok kategori produk.</p>
                        </div>
                        @isset($category)
                            <a href="{{ route('categories.index') }}" class="text-xs font-bold text-amber-700 hover:underline">Batal Edit</a>
                        @endisset
                    </div>

                    <form action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" method="POST" class="space-y-4">
                        @csrf
                        @isset($category)
                            @method('PUT')
                        @endisset

                        <div>
                            <label class="block text-xs font-bold text-stone-600 uppercase mb-1">Nama Kategori</label>
                            <input type="text" name="name" value="{{ $category->name ?? '' }}" required placeholder="Contoh: Elektronik" class="w-full bg-amber-50/40 border border-amber-200 rounded-2xl px-4 py-3 text-sm focus:ring-amber-700 focus:border-amber-700">
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="bg-amber-800 hover:bg-amber-900 text-white font-bold py-3 px-6 rounded-2xl shadow-md transition text-sm flex items-center space-x-2">
                                <i class="fa-solid {{ isset($category) ? 'fa-pen-to-square' : 'fa-plus-circle' }}"></i>
                                <span>{{ isset($category) ? 'Perbarui Kategori' : 'Simpan Kategori' }}</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tabel Kategori -->
                <div class="bg-white rounded-3xl shadow-sm border border-amber-100 overflow-hidden">
                    <div class="p-6 border-b border-amber-100 bg-amber-50/30">
                        <h3 class="text-lg font-bold text-stone-800">Daftar Kategori</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-amber-100/60 text-stone-600 uppercase text-xs tracking-wider border-b border-amber-100">
                                    <th class="py-4 px-6 font-bold">#</th>
                                    <th class="py-4 px-6 font-bold">Nama Kategori</th>
                                    <th class="py-4 px-6 font-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-amber-50 text-sm text-stone-600">
                                @forelse($categories as $c)
                                <tr class="hover:bg-amber-50/40 transition">
                                    <td class="py-4 px-6 font-bold text-stone-400">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-6 font-bold text-stone-800">{{ $c->name }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('categories.edit', $c->id) }}" class="bg-amber-50 hover:bg-amber-100 text-amber-700 px-3 py-1.5 rounded-xl text-xs font-bold transition border border-amber-200">
                                                <i class="fa-solid fa-pen mr-1"></i> Edit
                                            </a>
                                            <form action="{{ route('categories.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
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
                                    <td colspan="3" class="py-10 text-center text-stone-400">Belum ada data kategori.</td>
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