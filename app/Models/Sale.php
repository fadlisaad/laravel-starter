<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'sales_date',
        'sales_amount'
    ];

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop');
    }
}
