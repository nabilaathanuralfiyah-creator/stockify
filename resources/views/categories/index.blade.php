<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Stockify - Kelola Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Kelola Kategori Produk</h1>
            <a href="{{ route('products.index') }}" class="text-white bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg text-sm">← Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 bg-green-50 rounded-lg">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md h-fit">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">Tambah Kategori</h2>
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="name" required class="mt-1 w-full p-2.5 border rounded-lg focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" class="mt-1 w-full p-2.5 border rounded-lg focus:ring-blue-500"></textarea>
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Simpan</button>
                </form>
            </div>

            <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">Daftar Kategori</h2>
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Nama Kategori</th>
                            <th class="px-4 py-3">Deskripsi</th>
                            <th class="px-4 py-3">Total Produk</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $c)
                            <tr class="border-b">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $c->name }}</td>
                                <td class="px-4 py-3">{{ $c->description ?? '-' }}</td>
                                <td class="px-4 py-3 font-semibold">{{ $c->products_count }} Item</td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('categories.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-3 text-center">Belum ada kategori.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
