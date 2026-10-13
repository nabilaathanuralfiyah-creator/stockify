<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    up(): void
    {
        // Jika tabel transactions sudah ada, kita drop/ubah atau buat ulang secara aman
        Schema::dropIfExists('transactions');

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            // UBAH DARI char(1) MENJADI string('type', 10) AGAR TIDAK ERROR TRUNCATED LAGI
            $table->string('type', 10); 
            $table->integer('quantity');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    down(): void
    {
        Schema::dropIfExists('transactions');
    }
};