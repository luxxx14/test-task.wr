<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;

class OrderController extends Controller
{
    protected $product;
    protected $order;
    protected $orderProducts;

    public function __construct(
        Product $product,
        Order $order,
        OrderProduct $orderProducts
    ) {
        $this->product = $product;
        $this->order = $order;
        $this->orderProducts = $orderProducts;
    }

    public function showOrdersList() {
        //$orders = $this->order->getOrdersList();
        //$products_list = $this->product->orders()->get();

        //return view('orders', compact('orders'));
    }

    public function confirmOrder(Request $request)
    {
        $cartKey = CartController::getCartKey();
        $cart = Redis::hGetAll($cartKey);

        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Корзина пуста.');
        }

        $total = 0;
        $items = [];

        foreach ($cart as $item) {
            $itemData = json_decode($item, true);
            $total += floatval($itemData['price']) * intval($itemData['quantity']);
            $items[] = $itemData;
        }

        $order = $this->order::create([
            'user_id' => auth()->id(),
            'total_price' => $total,
        ]);

        foreach ($items as $item) {
            $this->orderProducts::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
            ]);
        }

        Redis::del($cartKey);

        return view('order_confirm');
    }

}

