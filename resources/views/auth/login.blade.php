<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Stockify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#2C221E] font-sans antialiased flex items-center justify-center h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-2xl border border-amber-100 space-y-6">
        
        <div class="text-center space-y-2">
            <div class="inline-flex bg-amber-700 p-3 rounded-2xl text-white shadow-lg mb-2">
                <i class="fa-solid fa-boxes-stacked text-2xl"></i>
            </div>
            <h1 class="text-2xl font-black text-stone-800 tracking-wider">STOCKIFY</h1>
            <p class="text-xs text-stone-400">Silakan masuk menggunakan akun terdaftar</p>
        </div>

        @if($errors->any())
            <div class="p-3 text-xs text-rose-700 rounded-xl bg-rose-50 border border-rose-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
            @csrf <!-- Ini wajib ada agar tidak muncul error 419 Page Expired -->
            
            <div>
                <label class="block text-xs font-bold text-stone-600 uppercase mb-1">Email</label>
                <input type="email" name="email" required placeholder="admin@stockify.com" class="w-full bg-amber-50/50 border border-amber-200 rounded-xl px-4 py-2.5 text-sm focus:ring-amber-700 focus:border-amber-700">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-600 uppercase mb-1">Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full bg-amber-50/50 border border-amber-200 rounded-xl px-4 py-2.5 text-sm focus:ring-amber-700 focus:border-amber-700">
            </div>

            <button type="submit" class="w-full bg-amber-800 hover:bg-amber-900 text-white font-bold py-3 rounded-xl shadow-md transition text-sm flex items-center justify-center space-x-2">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>Masuk Sistem</span>
            </button>
        </form>

    </div>

</body>
</html>