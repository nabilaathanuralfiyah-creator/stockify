<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockify - Aplikasi Manajemen Stok</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex">
        <!-- SIDEBAR KIRI -->
        <aside class="w-64 bg-[#78350f] text-white flex flex-col min-h-screen shadow-md fixed inset-y-0 left-0">
            <!-- Logo -->
            <div class="p-6 flex items-center space-x-3 border-b border-amber-800">
                <div class="w-10 h-10 bg-[#9a3412] rounded-xl flex items-center justify-center shadow-inner">
                    <span class="text-xl">📦</span>
                </div>
                <span class="text-2xl font-bold tracking-wider">STOCKIFY</span>
            </div>

            <!-- Navigasi Menu Dinamis Sesuai Role -->
            @php $role = strtolower(Auth::user()->role ?? 'admin'); @endphp
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('dashboard', ['tab' => 'dashboard']) }}" class="block px-4 py-2.5 rounded-lg {{ request('tab', 'dashboard') === 'dashboard' ? 'bg-[#5c280b] font-semibold text-white' : 'text-amber-100 hover:bg-amber-800' }} transition">
                    Dashboard
                </a>

                {{-- Admin & Manager Bisa Akses Produk & Kategori --}}
                @if(in_array($role, ['admin', 'manager']))
                <a href="{{ route('dashboard', ['tab' => 'products']) }}" class="block px-4 py-2.5 rounded-lg {{ request('tab') === 'products' ? 'bg-[#5c280b] font-semibold text-white' : 'text-amber-100 hover:bg-amber-800' }} transition">
                    Produk
                </a>
                <a href="{{ route('dashboard', ['tab' => 'categories']) }}" class="block px-4 py-2.5 rounded-lg {{ request('tab') === 'categories' ? 'bg-[#5c280b] font-semibold text-white' : 'text-amber-100 hover:bg-amber-800' }} transition">
                    Kategori
                </a>
                <a href="{{ route('dashboard', ['tab' => 'suppliers']) }}" class="block px-4 py-2.5 rounded-lg {{ request('tab') === 'suppliers' ? 'bg-[#5c280b] font-semibold text-white' : 'text-amber-100 hover:bg-amber-800' }} transition">
                    Supplier
                </a>
                @endif

                {{-- Khusus Admin Bisa Akses Manajemen Pengguna --}}
                @if($role === 'admin')
                <a href="{{ route('dashboard', ['tab' => 'users']) }}" class="block px-4 py-2.5 rounded-lg {{ request('tab') === 'users' ? 'bg-[#5c280b] font-semibold text-white' : 'text-amber-100 hover:bg-amber-800' }} transition">
                    Pengguna
                </a>
                @endif

                <!-- Operasional (Bisa Diakses Semua RoleTermasuk Staff) -->
                <div class="pt-4 pb-2 text-xs font-semibold text-amber-300 uppercase tracking-wider px-4">Operasional</div>
                <a href="{{ route('dashboard', ['tab' => 'transactions']) }}" class="block px-4 py-2.5 rounded-lg {{ request('tab') === 'transactions' ? 'bg-[#5c280b] font-semibold text-white' : 'text-amber-100 hover:bg-amber-800' }} transition">
                    Transaksi Stok
                </a>
                <a href="{{ route('dashboard', ['tab' => 'low-stock']) }}" class="block px-4 py-2.5 rounded-lg {{ request('tab') === 'low-stock' ? 'bg-[#5c280b] font-semibold text-white' : 'text-amber-100 hover:bg-amber-800' }} transition">
                    Stok Menipis
                </a>
            </nav>

            <!-- Tombol Keluar -->
            <div class="p-4 border-t border-amber-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-[#5c280b] hover:bg-black text-white text-center py-2 px-4 rounded-lg font-medium transition shadow">
                        Keluar Akun
                    </button>
                </form>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 flex flex-col min-w-0 ml-64">
            <header class="bg-white shadow flex justify-between items-center py-4 px-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    @yield('header', 'Stockify')
                </h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'User Stockify' }}</span>
                    
                    {{-- Badge Role Warna Berbeda --}}
                    @if($role === 'admin')
                        <span class="bg-red-800 text-white text-xs px-3 py-1 rounded-full font-bold uppercase">ROLE: ADMIN</span>
                    @elseif($role === 'manager')
                        <span class="bg-blue-800 text-white text-xs px-3 py-1 rounded-full font-bold uppercase">ROLE: MANAGER</span>
                    @else
                        <span class="bg-emerald-800 text-white text-xs px-3 py-1 rounded-full font-bold uppercase">ROLE: STAFF</span>
                    @endif
                </div>
            </header>

            <main class="flex-1 py-10 px-8 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>