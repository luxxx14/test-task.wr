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

    public function showOrdersList()
    {
        $orders = Order::with('orderProducts.product')->get();
        $totalOrdersAmount = 0;

        $orderData = $orders->map(function ($order) use (&$totalOrdersAmount) {
            // Общая стоимость товаров в заказе
            $orderItems = $order->orderProducts->map(function ($orderProduct) {
                return $orderProduct->product->name;
            });

            $orderItemsList = $orderItems->implode(', ');
            $orderTotalAmount = $order->orderProducts->sum(function ($orderProduct) {
                return $orderProduct->quantity * $orderProduct->product->price;
            });

            // Добавляем к итоговой стоимости
            $totalOrdersAmount += $orderTotalAmount;

            return [
                'order_id' => $order->id,
                'order_date' => $order->created_at->format('Y-m-d'),
                'items' => $orderItemsList,
                'total_amount' => $orderTotalAmount
            ];
        });

        return view('orders_list', compact('orderData', 'totalOrdersAmount'));
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

    public function deleteOrder($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return Redirect::back()->with('error', 'Заказ не найден.');
        }

        $order->orderProducts()->delete();
        $order->delete();

        return redirect()->route('orders.show')->with('success', 'Заказ успешно удален.');
    }

}

