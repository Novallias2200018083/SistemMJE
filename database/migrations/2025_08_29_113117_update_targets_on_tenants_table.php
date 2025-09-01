<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('tenants', function (Blueprint $table) {
        // Hapus kolom target yang lama
        if (Schema::hasColumn('tenants', 'daily_target')) {
            $table->dropColumn('daily_target');
        }

        // Tambahkan 3 kolom baru untuk target setiap hari
        $table->bigInteger('target_day_1')->default(0)->after('category');
        $table->bigInteger('target_day_2')->default(0)->after('target_day_1');
        $table->bigInteger('target_day_3')->default(0)->after('target_day_2');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            //
        });
    }
};
