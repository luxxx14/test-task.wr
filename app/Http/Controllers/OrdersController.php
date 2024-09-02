<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
//use App\Models\Catalog;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;

class OrdersController extends Controller
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }






    public function showOrdersList() {
        //$orders = $this->order->getOrdersList();
        //$products_list = $this->product->orders()->get();

        //return view('orders', compact('orders'));
    }

}
