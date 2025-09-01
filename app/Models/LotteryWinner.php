<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LotteryWinner extends Model
{
    use HasFactory;

    /**
     * Atribut yang tidak boleh diisi secara massal.
     * Menggunakan guarded kosong berarti semua atribut boleh diisi.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Tipe data asli dari atribut harus di-cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'drawn_at' => 'datetime',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model Attendee.
     * Setiap pemenang adalah seorang pengunjung (attendee).
     */
    public function attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class);
    }

        public function prize()
    {
        return $this->belongsTo(Prize::class);
    }
}