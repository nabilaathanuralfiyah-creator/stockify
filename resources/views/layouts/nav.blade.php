<nav class="bg-indigo-900 text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Brand Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ url('/products') }}" class="flex items-center space-x-2 text-xl font-bold tracking-wide hover:opacity-90 transition">
                    <span class="p-2 bg-indigo-600 rounded-lg text-white">
                        <i class="fa-solid fa-boxes-packing"></i>
                    </span>
                    <span>Stockify <span class="text-xs px-2 py-0.5 bg-indigo-700 text-indigo-200 rounded-full font-mono">v1.0</span></span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-1 text-sm font-medium">
                <a href="{{ url('/products') }}" class="px-3 py-2 rounded-md hover:bg-indigo-800 transition flex items-center gap-1.5 bg-indigo-800/60">
                    <i class="fa-solid fa-chart-line text-indigo-300"></i> Dashboard
                </a>
                
                <a href="{{ url('/categories') }}" class="px-3 py-2 rounded-md hover:bg-indigo-800 transition flex items-center gap-1.5 text-indigo-100">
                    <i class="fa-solid fa-tags text-indigo-300"></i> Kategori
                </a>

                <a href="{{ url('/suppliers') }}" class="px-3 py-2 rounded-md hover:bg-indigo-800 transition flex items-center gap-1.5 text-indigo-100">
                    <i class="fa-solid fa-truck text-indigo-300"></i> Supplier
                </a>

                <!-- Hanya Admin & Manager yang bisa lihat Stock Opname -->
                @if(Auth::check() && in_array(Auth::user()->role ?? 'admin', ['admin', 'manager']))
                <a href="{{ url('/stock-opname') }}" class="px-3 py-2 rounded-md hover:bg-indigo-800 transition flex items-center gap-1.5 text-indigo-100">
                    <i class="fa-solid fa-clipboard-check text-indigo-300"></i> Stock Opname
                </a>
                @endif

                <a href="{{ url('/reports') }}" class="px-3 py-2 rounded-md hover:bg-indigo-800 transition flex items-center gap-1.5 text-indigo-100">
                    <i class="fa-solid fa-file-invoice text-indigo-300"></i> Laporan
                </a>

                <!-- Hanya Admin yang bisa akses kelola Pengguna -->
                @if(Auth::check() && (Auth::user()->role ?? 'admin') === 'admin')
                <a href="{{ url('/users') }}" class="px-3 py-2 rounded-md hover:bg-indigo-800 transition flex items-center gap-1.5 text-indigo-100">
                    <i class="fa-solid fa-users text-indigo-300"></i> Pengguna
                </a>
                @endif
            </div>

            <!-- Profile & Logout Dropdown -->
            <div class="flex items-center space-x-3">
                <div class="text-right text-xs hidden sm:block">
                    <div class="font-bold text-white">{{ Auth::user()->name ?? 'Pengguna' }}</div>
                    <div class="text-indigo-300 uppercase tracking-wider text-[10px]">{{ Auth::user()->role ?? 'ADMIN' }}</div>
                </div>

                @if(Auth::check())
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="p-2 text-indigo-200 hover:text-white hover:bg-red-600/80 rounded-lg transition" title="Keluar">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</nav>