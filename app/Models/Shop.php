<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Shop extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $dates = [
        'request_time',
        'response_time'
    ];

    protected $fillable = [
        "store_name",
        "lng",
        "lat",
        "address",
        "phone_number",
        "email",
        "description",
        "person_in_charge",
        "status",
        "request_time",
        "response_time",
        "category_uuid",
        "creator_user_uuid",
        "store_uuid"
    ];
}
