<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockify - Layar Operasional Staff Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 p-8">

    <!-- Header & Logout -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-amber-900">Stockify (STAFF OPERASIONAL)</h1>
            <p class="text-gray-600">Selamat datang, {{ auth()->user()->name }} (Catat Mutasi Barang)</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</button>
        </form>
    </div>

    <!-- Form Khusus Staff Input Barang Masuk/Keluar -->
    <div class="bg-white p-6 rounded-lg shadow-md border border-amber-200 max-w-xl mx-auto">
        <h2 class="text-xl font-bold text-amber-800 mb-4">Catat Barang Masuk / Keluar</h2>
        
        <form action="#" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-medium text-gray-700">Pilih Produk</label>
                <select name="product_id" class="w-full p-2 border rounded mt-1">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (Sisa Stok: {{ $product->stock }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Jenis Transaksi</label>
                <select name="type" class="w-full p-2 border rounded mt-1">
                    <option value="in">Barang Masuk (+)</option>
                    <option value="out">Barang Keluar (-)</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Jumlah Unit</label>
                <input type="number" min="1" name="quantity" class="w-full p-2 border rounded mt-1" required>
            </div>

            <button type="submit" class="w-full bg-amber-600 text-white font-bold py-2 rounded hover:bg-amber-700">
                Simpan Transaksi
            </button>
        </form>
    </div>

</body>
</html>