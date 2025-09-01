<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


// ...
class Sale extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the tenant that owns the sale.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
        public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
    
}