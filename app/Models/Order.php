<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'id',
        'total_price',
        'user_id',
    ];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
