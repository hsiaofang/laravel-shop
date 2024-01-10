<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use Illuminate\Support\Facades\Session;
use App\Cart;



class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        dd($products);

        return view('home', ['products' => $products]);
    }

    public function getAddToCart(Request $request, $id)
    {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);
        Session::put('cart', $cart);
        // return redirect('/');
        // dd(Session::get('cart'));

        return redirect()->back()->with('success', '商品已成功加入購物車！');

    }

    public function cart()
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;

        if ($oldCart) {
            $cart = new Cart($oldCart);
            return view('cart', [
                'products' => $oldCart->items,
                'totalPrice' => $oldCart->totalPrice,
                'totalQty' => session('cartQuantity') ?? $oldCart->totalQty 
            ]);
        } else {
            return view('cart', [
                'products' => [],
                'totalPrice' => 0,
                'totalQty' => 0
            ]);
        }
    }
}
