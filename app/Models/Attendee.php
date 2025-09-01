<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


// ...
class Attendee extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the attendance records for the attendee.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}