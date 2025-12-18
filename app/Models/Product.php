<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'retail_price',
        'dealer_price',
        'moq',
        'category',
        'image',
        'stock',
        'bulk_discounts'
    ];

    protected $casts = [
        'bulk_discounts' => 'array',
    ];
}
