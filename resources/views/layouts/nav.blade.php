<nav class="bg-indigo-900 text-white p-4 mb-6 shadow-md">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <a href="/products" class="text-xl font-bold tracking-wide">Stockify Enterprise</a>
        
        <div class="flex items-center gap-6 text-sm font-medium">
            <div class="flex gap-4">
                <a href="/products" class="hover:text-indigo-200">Dashboard</a>
                <a href="/categories" class="hover:text-indigo-200">Kategori</a>
                <a href="/suppliers" class="hover:text-indigo-200">Supplier</a>
                <a href="/stock-opname" class="hover:text-indigo-200">Stock Opname</a>
                <a href="/reports" class="hover:text-indigo-200">Laporan</a>
                <a href="/users" class="hover:text-indigo-200">Pengguna</a>
            </div>

            @auth
            <div class="flex items-center gap-3 border-l pl-4 border-indigo-700">
                <span class="text-xs bg-indigo-800 px-2 py-1 rounded">
                    {{ Auth::user()->name }} ({{ strtoupper(Auth::user()->role ?? 'Staff') }})
                </span>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                        Keluar
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>
</nav>
