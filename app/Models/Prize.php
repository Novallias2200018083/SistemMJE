<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function winners()
    {
        return $this->hasMany(LotteryWinner::class);
    }
}