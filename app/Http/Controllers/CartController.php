<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart; // 假設您已經建立了 Cart 模型

class CartController extends Controller
{
    public function index()
    {        
        $cartItems = Cart::with('product')->get();

        return view('cart', compact('cartItems'));
    }
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $userId = Auth::id();

        // 檢查購物車中是否已經存在此產品
        $existingCartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingCartItem) {
            // 如果購物車中已存在該產品，則更新產品數量
            $existingCartItem->increment('quantity');
            return response()->json(['message' => '已更新購物車'], 200);
        } else {
            // 如果購物車中不存在該產品，則創建新的購物車項目
            $cartItem = Cart::create([
                'product_id' => $productId,
                'user_id' => $userId,
                'quantity' => 1, // 或者您想要的起始數量
            ]);

            if ($cartItem) {
                return response()->json(['message' => '已加入購物車'], 200);
            } else {
                return back()->with('error', '加入購物車失敗，請稍後再試！');
            }
        }
    }

}
