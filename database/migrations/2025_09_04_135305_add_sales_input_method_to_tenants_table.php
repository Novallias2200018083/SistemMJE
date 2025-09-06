<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            // Kolom ini akan menyimpan 'total' atau 'detail'.
            // Nullable berarti tenan belum memilih.
            $table->string('sales_input_method')->nullable()->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn('sales_input_method');
        });
    }
};