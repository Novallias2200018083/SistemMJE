<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// ...
class Tenant extends Model
{
    use HasFactory;

    // GANTI ARRAY $fillable ANDA DENGAN INI
    protected $fillable = [
        'user_id',
        'tenant_name',
        'category',
        'total_sales',
        // TAMBAHKAN TIGA BARIS INI
        'target_day_1',
        'target_day_2',
        'target_day_3',
    ];

    protected $guarded = []; // Atau definisikan $fillable

    /**
     * Get the user that owns the tenant profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sales for the tenant.
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}