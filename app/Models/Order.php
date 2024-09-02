<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Связь с товаром
    public function product()
    {
        //return $this->belongsTo(Product::class);
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
