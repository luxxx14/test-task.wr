<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
//use App\Models\Catalog;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class CatalogController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }






    public function showCatalog() {
        $products = $this->product->getAllProducts();
        //$products_list = $this->product->orders()->get();

        return view('welcome', compact('products'));
    }

}
