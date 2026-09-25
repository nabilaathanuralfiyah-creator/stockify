<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok & Transaksi - Stockify</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Laporan Mutasi Stok</h1>
            <a href="/products" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali ke Dashboard</a>
        </div>

        <form method="GET" action="/reports" class="flex gap-4 mb-6 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="border rounded px-3 py-2">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter Laporan</button>
            <button type="button" onclick="window.print()" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Cetak Laporan / PDF</button>
        </form>

        <h2 class="text-lg font-semibold mb-3 text-gray-700">Riwayat Mutasi Barang</h2>
        <table class="w-full text-left border-collapse border border-gray-200 mb-8">
            <thead>
                <tr class="bg-gray-50">
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Produk</th>
                    <th class="border p-2">Tipe</th>
                    <th class="border p-2">Jumlah</th>
                    <th class="border p-2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                <tr>
                    <td class="border p-2">{{ $t->created_at->format('Y-m-d H:i') }}</td>
                    <td class="border p-2">{{ $t->product->name ?? 'Produk Dihapus' }}</td>
                    <td class="border p-2 font-bold {{ $t->type == 'in' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $t->type == 'in' ? 'MASUK (+)' : 'KELUAR (-)' }}
                    </td>
                    <td class="border p-2">{{ $t->quantity }}</td>
                    <td class="border p-2">{{ $t->notes ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="border p-2 text-center text-gray-500">Tidak ada transaksi pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <h2 class="text-lg font-semibold mb-3 text-red-600">Peringatan Stok Menipis</h2>
        <table class="w-full text-left border-collapse border border-gray-200">
            <thead>
                <tr class="bg-red-50">
                    <th class="border p-2">Nama Produk</th>
                    <th class="border p-2">Stok Saat Ini</th>
                    <th class="border p-2">Batas Minimum</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lowStockProducts as $p)
                <tr>
                    <td class="border p-2 font-medium">{{ $p->name }}</td>
                    <td class="border p-2 font-bold text-red-600">{{ $p->stock }}</td>
                    <td class="border p-2">{{ $p->min_stock }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="border p-2 text-center text-gray-500">Semua stok produk dalam kondisi aman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
