@extends('layouts.app')

@section('header')
    @if(request('tab', 'dashboard') === 'dashboard') Beranda Utama
    @elseif(request('tab') === 'products') Manajemen Produk
    @elseif(request('tab') === 'categories') Kategori Produk
    @elseif(request('tab') === 'suppliers') Supplier / Vendor
    @elseif(request('tab') === 'users') Manajemen Pengguna
    @elseif(request('tab') === 'transactions') Transaksi Stok
    @elseif(request('tab') === 'low-stock') Peringatan Stok Menipis
    @endif
@endsection

@section('content')
<div class="space-y-6">

    @php 
        $userRole = strtolower(Auth::user()->role ?? 'admin'); 
        // Menyiapkan data untuk Grafik (mengambil maksimal 6 produk pertama)
        $chartProducts = isset($products) ? $products->take(6) : collect();
        $chartLabels = $chartProducts->pluck('name')->toJson();
        $chartData = $chartProducts->pluck('stock')->toJson();
    @endphp

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm">
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- TAB 1: DASHBOARD UTAMA (DENGAN GRAFIK & STATISTIK TAMBAHAN) --}}
    @if(request('tab', 'dashboard') === 'dashboard')
        {{-- Banner Sambutan --}}
        <div class="bg-[#291507] text-white p-6 rounded-2xl shadow-md flex justify-between items-center">
            <div>
                <h3 class="text-2xl font-bold">
                    Halo, {{ Auth::user()->name ?? 'User' }}! 👋
                </h3>
                <p class="text-amber-200 text-sm mt-1">
                    Anda masuk sebagai <span class="font-bold uppercase text-white">{{ $userRole }}</span>. Selamat bekerja dan mengelola inventaris gudang hari ini.
                </p>
            </div>
            <div class="text-right hidden md:block">
                <span class="text-xs uppercase tracking-wider text-amber-300 font-semibold">Waktu Server</span>
                <div class="text-lg font-bold">{{ date('d M Y') }}</div>
            </div>
        </div>

        {{-- Kartu Statistik Utama --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200 flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-xs font-semibold uppercase">Total Produk</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ $totalProducts ?? 0 }} <span class="text-sm font-normal text-gray-500">Item</span></div>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-700 text-xl font-bold">📦</div>
            </div>

            <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200 flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-xs font-semibold uppercase">Total Stok Barang</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ $totalStock ?? 0 }} <span class="text-sm font-normal text-gray-500">Unit</span></div>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-700 text-xl font-bold">📊</div>
            </div>

            <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200 flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-xs font-semibold uppercase">Stok Menipis</div>
                    <div class="text-3xl font-bold text-red-600 mt-2">{{ $lowStockCount ?? 0 }} <span class="text-sm font-normal text-gray-500">Produk</span></div>
                </div>
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-red-600 text-xl font-bold">⚠️</div>
            </div>

            <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200 flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-xs font-semibold uppercase">Total Supplier</div>
                    <div class="text-3xl font-bold text-gray-900 mt-2">{{ $totalSuppliers ?? 0 }} <span class="text-sm font-normal text-gray-500">Vendor</span></div>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-700 text-xl font-bold">🚚</div>
            </div>
        </div>

        {{-- Bagian Grafik & Aktivitas Tambahan --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Grafik Batang Stok Produk (Menggunakan Chart.js CDN) --}}
            <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200 lg:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-lg font-bold text-gray-800">📈 Grafik Perbandingan Stok Produk</h4>
                    <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-1 rounded-md">Top Produk Gudang</span>
                </div>
                <div class="relative h-72">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>

            {{-- Ringkasan Status & Tips Cepat --}}
            <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200 flex flex-col justify-between">
                <div>
                    <h4 class="text-lg font-bold text-gray-800 mb-3">💡 Status & Pintasan</h4>
                    <p class="text-sm text-gray-600 mb-4">Gunakan fitur transaksi stok untuk mencatat barang masuk atau keluar secara real-time.</p>
                    
                    <div class="space-y-3">
                        <div class="p-3 bg-amber-50 rounded-lg border border-amber-200 text-xs text-amber-900 flex items-center justify-between">
                            <span class="font-semibold">Perhatian Stok:</span>
                            <span class="font-bold">{{ $lowStockCount ?? 0 }} Item Kritis</span>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-200 text-xs text-blue-900 flex items-center justify-between">
                            <span class="font-semibold">Total Kategori:</span>
                            <span class="font-bold">{{ isset($categories) ? $categories->count() : 0 }} Kategori</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                    <a href="{{ route('dashboard', ['tab' => 'transactions']) }}" class="inline-block w-full bg-[#78350f] hover:bg-amber-900 text-white font-bold py-2.5 px-4 rounded-xl shadow text-sm transition">
                        Catat Transaksi Baru ➔
                    </a>
                </div>
            </div>
        </div>

        {{-- SCRIPT CHART.JS --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById('stockChart').getContext('2d');
                const stockChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! $chartLabels !!},
                        datasets: [{
                            label: 'Jumlah Stok (Unit)',
                            data: {!! $chartData !!},
                            backgroundColor: 'rgba(120, 53, 15, 0.8)',
                            borderColor: 'rgba(120, 53, 15, 1)',
                            borderWidth: 1,
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            });
        </script>
    @endif

    {{-- TAB 2: PRODUK --}}
    @if(request('tab') === 'products')
        @if(in_array($userRole, ['admin', 'manager']))
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">➕ Tambah Produk Baru</h3>
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Produk (SKU)</label>
                        <input type="text" name="code" class="w-full rounded-lg border-gray-300 border p-2.5" placeholder="Contoh: PRD-001" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                        <input type="text" name="name" class="w-full rounded-lg border-gray-300 border p-2.5" placeholder="Contoh: Laptop Gaming" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" class="w-full rounded-lg border-gray-300 border p-2.5" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Awal</label>
                        <input type="number" name="stock" min="0" class="w-full rounded-lg border-gray-300 border p-2.5" placeholder="0" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="price" min="0" class="w-full rounded-lg border-gray-300 border p-2.5" placeholder="100000" required>
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-[#78350f] hover:bg-amber-900 text-white font-bold py-2.5 px-6 rounded-xl shadow">Simpan Produk</button>
                </div>
            </form>
        </div>
        @endif

        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Daftar Produk Gudang</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Kode</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Nama Produk</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Kategori</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Stok</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Harga</th>
                            @if($userRole === 'admin')<th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Aksi</th>@endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $i => $p)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $i + 1 }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-amber-900">{{ $p->code ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $p->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $p->category->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $p->stock }} Unit</td>
                                <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                                @if($userRole === 'admin')
                                <td class="px-6 py-4 text-sm font-medium">
                                    <form action="{{ route('products.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada data produk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- TAB 3: KATEGORI --}}
    @if(request('tab') === 'categories')
        @if(in_array($userRole, ['admin', 'manager']))
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">➕ Tambah Kategori Baru</h3>
            <form action="{{ route('categories.store') }}" method="POST" class="flex gap-4">
                @csrf
                <input type="text" name="name" class="flex-1 rounded-lg border-gray-300 border p-2.5" placeholder="Nama Kategori Baru" required>
                <button type="submit" class="bg-[#78350f] hover:bg-amber-900 text-white font-bold py-2.5 px-6 rounded-xl shadow">Simpan Kategori</button>
            </form>
        </div>
        @endif

        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Daftar Kategori Produk</h3>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Nama Kategori</th>
                        @if($userRole === 'admin')<th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Aksi</th>@endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $i => $c)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $c->name }}</td>
                            @if($userRole === 'admin')
                            <td class="px-6 py-4 text-sm font-medium">
                                <form action="{{ route('categories.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus kategori?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 font-bold">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada data kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    {{-- TAB 4: SUPPLIER --}}
    @if(request('tab') === 'suppliers')
        @if(in_array($userRole, ['admin', 'manager']))
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">➕ Tambah Supplier Baru</h3>
            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="name" class="rounded-lg border-gray-300 border p-2.5" placeholder="Nama Supplier / PT" required>
                    <input type="text" name="phone" class="rounded-lg border-gray-300 border p-2.5" placeholder="No Telepon / WhatsApp">
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-[#78350f] text-white font-bold py-2.5 px-6 rounded-xl shadow">Simpan Supplier</button>
                </div>
            </form>
        </div>
        @endif

        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Daftar Supplier / Vendor</h3>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Nama Supplier</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">No Telepon</th>
                        @if($userRole === 'admin')<th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Aksi</th>@endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($suppliers as $i => $s)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $s->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $s->phone ?? '-' }}</td>
                            @if($userRole === 'admin')
                            <td class="px-6 py-4 text-sm font-medium">
                                <form action="{{ route('suppliers.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus supplier?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 font-bold">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada data supplier.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    {{-- TAB 5: PENGGUNA (Khusus Admin) --}}
    @if(request('tab') === 'users' && $userRole === 'admin')
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">➕ Tambah Pengguna Baru</h3>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="text" name="name" class="rounded-lg border-gray-300 border p-2.5" placeholder="Nama Lengkap" required>
                    <input type="email" name="email" class="rounded-lg border-gray-300 border p-2.5" placeholder="email@stockify.com" required>
                    <input type="password" name="password" class="rounded-lg border-gray-300 border p-2.5" placeholder="Password" required>
                    <select name="role" class="rounded-lg border-gray-300 border p-2.5" required>
                        <option value="staff">Role: Staff</option>
                        <option value="manager">Role: Manager</option>
                        <option value="admin">Role: Admin</option>
                    </select>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-[#78350f] text-white font-bold py-2.5 px-6 rounded-xl shadow">Simpan Akun</button>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Daftar Pengguna Sistem</h3>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $i => $u)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $u->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $u->email }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-full uppercase {{ $u->role === 'admin' ? 'bg-red-100 text-red-800' : ($u->role === 'manager' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $u->role ?? 'staff' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                @if($u->id !== Auth::id())
                                <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 font-bold">Hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada user.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    {{-- TAB 6: TRANSAKSI STOK --}}
    @if(request('tab') === 'transactions')
        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">📝 Catat Transaksi Stok Baru</h3>
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Produk</label>
                        <select name="product_id" class="w-full rounded-lg border-gray-300 border p-2.5" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $prod)
                                <option value="{{ $prod->id }}">{{ $prod->name }} (Stok: {{ $prod->stock }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Transaksi</label>
                        <select name="type" class="w-full rounded-lg border-gray-300 border p-2.5" required>
                            <option value="masuk">Stok Masuk (+)</option>
                            <option value="keluar">Stok Keluar (-)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Unit</label>
                        <input type="number" name="quantity" min="1" class="w-full rounded-lg border-gray-300 border p-2.5" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Catatan</label>
                        <input type="text" name="note" class="w-full rounded-lg border-gray-300 border p-2.5" placeholder="Contoh: Restok baru">
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-[#78350f] text-white font-bold py-2.5 px-6 rounded-xl shadow">Simpan Transaksi</button>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Riwayat Transaksi Stok</h3>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Produk</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Jenis</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Jumlah</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Keterangan</th>
                        @if($userRole === 'admin')<th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Aksi</th>@endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $i => $trx)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $trx->product->name ?? 'Produk Dihapus' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ strtolower($trx->type) === 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ strtoupper($trx->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-semibold">{{ $trx->quantity }} Unit</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $trx->note ?? '-' }}</td>
                            @if($userRole === 'admin')
                            <td class="px-6 py-4 text-sm font-medium">
                                <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 font-bold">Hapus</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada riwayat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    {{-- TAB 7: STOK MENIPIS --}}
    @if(request('tab') === 'low-stock')
        <div class="bg-white shadow-sm rounded-xl p-6 border border-red-200">
            <h3 class="text-lg font-bold text-red-700 mb-4">⚠️ Peringatan Stok Menipis (&lt;= 5 Unit)</h3>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Nama Produk</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase">Sisa Stok</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($lowStockProducts as $i => $item)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $item->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->category->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-red-600">{{ $item->stock }} Unit (Segera Restok!)</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">Aman! Tidak ada stok menipis.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection