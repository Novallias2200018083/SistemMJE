<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // ...add_prize_id_to_lottery_winners_table.php
    public function up(): void
    {
        Schema::table('lottery_winners', function (Blueprint $table) {
            $table->foreignId('prize_id')->constrained()->after('attendee_id');
            $table->boolean('is_claimed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lottery_winners', function (Blueprint $table) {
        // 1. Hapus foreign key constraint terlebih dahulu
        $table->dropForeign(['prize_id']);

        // 2. Baru hapus kolomnya
        $table->dropColumn('prize_id');
    });
    }
};
