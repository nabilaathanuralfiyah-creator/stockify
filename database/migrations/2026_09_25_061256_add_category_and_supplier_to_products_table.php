<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null')->after('id');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null')->after('category_id');
            $table->integer('min_stock')->default(5)->after('stock'); // Untuk Alert Stok Menipis
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['supplier_id']);
            $table->dropColumn(['category_id', 'supplier_id', 'min_stock']);
        });
    }
};
