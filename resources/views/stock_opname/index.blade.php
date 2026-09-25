<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Opname - Stockify</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Stock Opname (Penyesuaian Stok)</h1>
            <a href="/products" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 font-medium">
                {{ session('success') }}
            </div>
        @endif

        <form action="/stock-opname" method="POST" class="space-y-4 bg-gray-50 p-6 rounded border border-gray-200 mb-8">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Pilih Produk</label>
                <select name="product_id" required class="w-full border rounded p-2 text-sm mt-1">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (Stok Sistem: {{ $product->stock }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Jumlah Stok Fisik Riil</label>
                <input type="number" name="physical_stock" required min="0" class="w-full border rounded p-2 text-sm mt-1" placeholder="Masukkan jumlah fisik di gudang">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Alasan / Catatan Penyesuaian</label>
                <input type="text" name="notes" required class="w-full border rounded p-2 text-sm mt-1" placeholder="Misal: Barang rusak / hilang / selisih hitung">
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700 font-medium">
                Simpan Penyesuaian
            </button>
        </form>
    </div>
</body>
</html>
