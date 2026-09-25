<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Stockify</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h1>
            <a href="/products" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 font-medium">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Tambah User -->
        <form action="/users" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 bg-gray-50 p-4 rounded border border-gray-200">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" required class="w-full border rounded p-2 text-sm mt-1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" required class="w-full border rounded p-2 text-sm mt-1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="w-full border rounded p-2 text-sm mt-1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" required class="w-full border rounded p-2 text-sm mt-1">
                    <option value="staff">Staff Gudang</option>
                    <option value="manajer">Manajer Gudang</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="md:col-span-4 text-right">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 text-sm font-medium">
                    + Tambah Pengguna
                </button>
            </div>
        </form>

        <!-- Tabel Daftar User -->
        <table class="w-full text-left border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-3">Nama</th>
                    <th class="border p-3">Email</th>
                    <th class="border p-3">Role</th>
                    <th class="border p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="border p-3 font-medium">{{ $user->name }}</td>
                    <td class="border p-3">{{ $user->email }}</td>
                    <td class="border p-3 capitalize">
                        <span class="px-2 py-1 text-xs font-semibold rounded 
                            {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : ($user->role == 'manajer' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                            {{ $user->role ?? 'Staff' }}
                        </span>
                    </td>
                    <td class="border p-3 text-center">
                        <form action="/users/{{ $user->id }}" method="POST" onsubmit="return confirm('Yakin hapus pengguna ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
