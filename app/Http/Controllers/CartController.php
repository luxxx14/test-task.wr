<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class CartController extends Controller
{
    protected $product;


    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public static function getCartKey()
    {
        return 'cart:' . auth()->id();
    }

    public function showCart() {
        $cartKey = $this->getCartKey();
        $cart = Redis::hGetAll($cartKey);
        $total = 0;
        foreach ($cart as &$item) {
            $item = json_decode($item, true);
            $total += floatval($item['price']) * intval($item['quantity']);
        }
        $cart['total'] = $total;

        return view('cart', compact('cart'));
    }

    public function addCartItem(Request $request, $product_id) {
        $product = $this->product->find($product_id);
        if (!$product) {
            return redirect()->back()->withErrors('Продукт не найден.');
        }

        $quantity = $request->input('quantity', 1);
        $cartKey = $this->getCartKey();

        $cart = Redis::hGetAll($cartKey);

        if (isset($cart[$product_id])) {
            $cartItem = json_decode($cart[$product_id], true);
            $cartItem['quantity'] += $quantity;
            Redis::hSet($cartKey, $product_id, json_encode($cartItem));
        } else {
            $cartItem = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
            Redis::hSet($cartKey, $product_id, json_encode($cartItem));
        }

        return redirect()->back()->with('success', 'Продукт добавлен в корзину.');
    }

    public function updateCart(Request $request, $product_id) {
        $quantity = $request->input('quantity', 1);
        $cartKey = $this->getCartKey();

        if (Redis::hExists($cartKey, $product_id)) {
            $cartItem = json_decode(Redis::hGet($cartKey, $product_id), true);
            $cartItem['quantity'] = $quantity;
            Redis::hSet($cartKey, $product_id, json_encode($cartItem));
        }

        return redirect()->route('cart.show')->with('success', 'Корзина обновлена.');
    }

    public function deleteCartItem($product_id) {
        $cartKey = $this->getCartKey();

        Redis::hDel($cartKey, $product_id);

        return redirect()->route('cart.show')->with('success', 'Продукт удален из корзины.');
    }

}
