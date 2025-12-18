<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeletedDealerRecord extends Model
{
    protected $fillable = [
        'admin_id',
        'admin_name',
        'dealer_info',
        'deleted_at'
    ];

    protected $casts = [
        'dealer_info' => 'array',
        'deleted_at' => 'datetime'
    ];
}
