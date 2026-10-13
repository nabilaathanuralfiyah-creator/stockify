<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', fn() => view('auth.login'))->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
})->name('login.process');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Single Page Application (SPA) & Operasional Route Group
Route::middleware(['auth'])->group(function () {
    
    // Halaman Utama Dinamis (Tab Based)
    Route::get('/', function (Request $request) {
        $tab = $request->query('tab', 'dashboard');

        $totalProducts = Product::count();
        $totalStock = Product::sum('stock') ?? 0;
        $lowStockProducts = Product::with('category')->where('stock', '<=', 5)->get();
        $lowStockCount = $lowStockProducts->count();
        $totalSuppliers = Supplier::count();
        
        $products = Product::with('category')->get();
        $categories = Category::all();
        $suppliers = Supplier::all();
        $users = User::all();
        $transactions = Transaction::with('product')->latest()->get();

        return view('dashboard', compact(
            'tab',
            'totalProducts', 
            'totalStock', 
            'lowStockCount', 
            'lowStockProducts', 
            'totalSuppliers', 
            'products', 
            'categories', 
            'suppliers',
            'users',
            'transactions'
        ));
    })->name('dashboard');

    Route::get('/dashboard', function (Request $request) {
        return redirect()->route('dashboard', ['tab' => $request->query('tab', 'dashboard')]);
    });

    // Alias Rute Sidebar Samping
    Route::get('/products', fn() => redirect()->route('dashboard', ['tab' => 'products']))->name('products.index');
    Route::get('/categories', fn() => redirect()->route('dashboard', ['tab' => 'categories']))->name('categories.index');
    Route::get('/suppliers', fn() => redirect()->route('dashboard', ['tab' => 'suppliers']))->name('suppliers.index');
    Route::get('/users', fn() => redirect()->route('dashboard', ['tab' => 'users']))->name('users.index');
    Route::get('/transactions', fn() => redirect()->route('dashboard', ['tab' => 'transactions']))->name('transactions.index');
    Route::get('/low-stock', fn() => redirect()->route('dashboard', ['tab' => 'low-stock']))->name('products.low-stock');

    // ==========================================
    // 1. MANAJEMEN PRODUK (Tambah & Hapus)
    // ==========================================
    Route::post('/products', function (Request $request) {
        $request->validate([
            'code' => 'required|string|max:50|unique:products,code',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        Product::create($request->all());

        return redirect()->route('dashboard', ['tab' => 'products'])->with('success', 'Produk berhasil ditambahkan.');
    })->name('products.store');

    Route::delete('/products/{id}', function ($id) {
        Product::findOrFail($id)->delete();
        return redirect()->route('dashboard', ['tab' => 'products'])->with('success', 'Produk berhasil dihapus.');
    })->name('products.destroy');

    // ==========================================
    // 2. MANAJEMEN KATEGORI (Tambah & Hapus - Otomatis Slug)
    // ==========================================
    Route::post('/categories', function (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('dashboard', ['tab' => 'categories'])->with('success', 'Kategori berhasil ditambahkan.');
    })->name('categories.store');

    Route::delete('/categories/{id}', function ($id) {
        Category::findOrFail($id)->delete();
        return redirect()->route('dashboard', ['tab' => 'categories'])->with('success', 'Kategori berhasil dihapus.');
    })->name('categories.destroy');

    // ==========================================
    // 3. MANAJEMEN SUPPLIER (Tambah & Hapus)
    // ==========================================
    Route::post('/suppliers', function (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        Supplier::create($request->all());

        return redirect()->route('dashboard', ['tab' => 'suppliers'])->with('success', 'Supplier berhasil ditambahkan.');
    })->name('suppliers.store');

    Route::delete('/suppliers/{id}', function ($id) {
        Supplier::findOrFail($id)->delete();
        return redirect()->route('dashboard', ['tab' => 'suppliers'])->with('success', 'Supplier berhasil dihapus.');
    })->name('suppliers.destroy');

    // ==========================================
    // 4. MANAJEMEN PENGGUNA (Tambah & Hapus)
    // ==========================================
    Route::post('/users', function (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,manager,staff',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('dashboard', ['tab' => 'users'])->with('success', 'Pengguna baru berhasil ditambahkan.');
    })->name('users.store');

    Route::delete('/users/{id}', function ($id) {
        User::findOrFail($id)->delete();
        return redirect()->route('dashboard', ['tab' => 'users'])->with('success', 'Pengguna berhasil dihapus.');
    })->name('users.destroy');

    // ==========================================
    // 5. MANAJEMEN TRANSAKSI STOK (Simpan & Hapus)
    // ==========================================
    Route::post('/transactions', function (Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:masuk,keluar',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->type === 'keluar' && $product->stock < $request->quantity) {
            return redirect()->route('dashboard', ['tab' => 'transactions'])->with('error', 'Stok tidak mencukupi untuk pengeluaran tersebut!');
        }

        Transaction::create($request->all());

        if ($request->type === 'masuk') {
            $product->stock += $request->quantity;
        } else {
            $product->stock -= $request->quantity;
        }
        $product->save();

        return redirect()->route('dashboard', ['tab' => 'transactions'])->with('success', 'Transaksi berhasil dicatat dan stok diperbarui.');
    })->name('transactions.store');

    Route::delete('/transactions/{id}', function ($id) {
        $trx = Transaction::findOrFail($id);
        $product = Product::find($trx->product_id);

        if ($product) {
            if ($trx->type === 'masuk') {
                $product->stock -= $trx->quantity;
            } else {
                $product->stock += $trx->quantity;
            }
            $product->save();
        }

        $trx->delete();

        return redirect()->route('dashboard', ['tab' => 'transactions'])->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan.');
    })->name('transactions.destroy');
});