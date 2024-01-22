<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Cart;



class ProductController extends Controller
{
    // public function index()
    // {
    //     // $products = Product::all();
    //     // dd($products);

    // return view('cart', compact('cart', 'totalPrice', 'totalQty'));
    // }

    public function addToCart(Request $request, $id)
    {
        // dd($request);
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);
        Session::put('cart', $cart);
        return redirect()->back()->with('success', '商品已成功加入購物車！');

    }

    public function addTofavorite(Request $request, $id)
    {
        // dd($request);
        $product = Product::find($id);
        $product && !Session::has('favorites.' . $id);
        Session::put('favorites.' . $id, $product);
        return redirect()->back()->with('success', '商品已成功加入收藏！');
    }

    public function favorite()
    {
        $favorites = Session::get('favorites', []);
        // dd($favorites);
        return view('favorite', ['favorites' => $favorites]);
    }


    public function removeFavorite($productId)
    {
        $favorites = Session::get('favorites', []);
        // dd($favorites); 
        $index = array_search($productId, $favorites);
        if ($index !== false && $index !== null) {
            unset($favorites[$index]);
            Session::put('favorites', array_values($favorites));

            return response()->json(['success' => true, 'message' => '商品已取消收藏', 'favorites' => Session::get('favorites', [])]);
        }

        return response()->json(['success' => false, 'error' => '商品不存在於收藏中']);
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


    public function returnShop()
    {
        return redirect()->route('home');
    }


    // 後台部分
    public function edit($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('admin.product')->with('error', '找不到該產品');
        }

        return response()->json($product); // 將產品資料以 JSON 格式返回給前端
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => '找不到該產品'], 404);
        }

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->save();

        return response()->json(['message' => '產品已成功更新']);
    }


    public function delete($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => '找不到指定的商品'], 404);
        }

        $product->delete();
        return redirect()->back()->with('success', '商品刪除成功！');


        // return response()->json(['success' => true, 'message' => '商品已成功刪除']);
    }




}
