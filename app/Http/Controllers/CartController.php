<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
//use App\Models\Catalog;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    public function showCart() {

    }

    public function addCartItem() {

    }

    public function deleteCartItem() {

    }

    

    /*

// Запись в Redis
Redis::set('name', 'Taylor');

// Чтение из Redis
$value = Redis::get('name');

// Работа с хешами
Redis::hset('users', '1', 'Taylor');
$user = Redis::hget('users', '1');


// Работа с транзакциями
Redis::multi()
    ->set('key1', 'value1')
    ->set('key2', 'value2')
    ->exec();

    */

}
