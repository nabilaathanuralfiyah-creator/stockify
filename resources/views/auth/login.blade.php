<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Stockify Enterprise</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-indigo-900 mb-6">Stockify Enterprise</h2>
        
        @if($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" required class="w-full border rounded p-2 text-sm mt-1" placeholder="admin@stockify.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="w-full border rounded p-2 text-sm mt-1" placeholder="••••••••">
            </div>
            <button type="submit" class="w-full bg-indigo-900 text-white py-2 rounded hover:bg-indigo-800 font-medium">
                Masuk Sistem
            </button>
        </form>
    </div>
</body>
</html>
