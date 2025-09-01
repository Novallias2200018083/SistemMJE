<?php

// path: database/migrations/...._create_lottery_winners_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lottery_winners', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel pengunjung
            $table->foreignId('attendee_id')->constrained()->onDelete('cascade');
            $table->timestamp('drawn_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lottery_winners');
    }
};