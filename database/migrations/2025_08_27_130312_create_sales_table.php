<?php

// path: database/migrations/...._create_sales_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel tenan
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2); // Jumlah penjualan
            $table->date('sale_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};