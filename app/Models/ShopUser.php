<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'user_id'
    ];

    public function shop()
    {
        return $this->hasMany('App\Models\Shop', 'id', 'shop_id');
    }

    public function user()
    {
        return $this->hasMany('App\Models\User');
    }
}
