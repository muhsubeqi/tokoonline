<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'ekspedisi' => 'array'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'cities_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}