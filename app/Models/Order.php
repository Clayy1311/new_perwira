<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'plan',
        'amount',
        'status',
        'token',          
        'redirect_url'  
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
