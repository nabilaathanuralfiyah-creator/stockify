# Stockify - Warehouse Management System

Stockify adalah sistem manajemen inventaris gudang berbasis web yang dibangun menggunakan framework Laravel 10, Tailwind CSS, dan SQLite/MySQL.

## Fitur Utama

1. Dashboard & Manajemen Produk: Pengelolaan data produk, stok minimum, serta indikator stok menipis secara real-time.
2. Mutasi Stok: Pencatatan transaksi Barang Masuk (+) dan Barang Keluar (-).
3. Master Data: Pengelolaan Kategori Produk dan Supplier.
4. Stock Opname: Penyesuaian stok riil fisik gudang dengan pencatatan otomatis selisih transaksi.
5. Laporan & Cetak: Riwayat mutasi stok, filter periode tanggal, serta fitur cetak laporan ke PDF.
6. Autentikasi & Pengguna: Akses terlindungi middleware login dengan peran Admin & Staff Gudang.

## Kredensial Login Default

- Admin: admin@stockify.com / password
- Staff: staff@stockify.com / password

## Cara Menjalankan Proyek

1. Install dependensi:
   composer install && npm install

2. Setup Lingkungan (.env):
   cp .env.example .env && php artisan key:generate

3. Jalankan Migrasi & Seeder:
   php artisan migrate --seed

4. Jalankan Server Local:
   php artisan serve
