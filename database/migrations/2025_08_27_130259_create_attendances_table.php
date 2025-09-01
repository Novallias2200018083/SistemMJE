<?php

// path: database/migrations/...._create_attendances_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel pengunjung
            $table->foreignId('attendee_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('day');
            $table->timestamp('attended_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
