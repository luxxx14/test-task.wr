<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    // Указываем, если есть первичный ключ (если не 'id')
    //protected $primaryKey = 'product_id';

    // Если таблица не использует timestamps (created_at и updated_at)
    public $timestamps = false;


    public function getAllProducts() {
        return self::all();
    }






    // Связь с заказами
    public function orders()
    {
        //return $this->hasMany(Order::class);
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }
}
