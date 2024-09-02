<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{
    protected $product;
    protected $order;

    public function __construct(
        Product $product,
        Order $order
    ) {
        $this->product = $product;
        $this->product = $order;
    }

    public function showCatalog() {
        $products = $this->product->getAllProducts();

        return view('welcome', compact('products'));
    }

    public function confirmOrder() {
        
    }

}

