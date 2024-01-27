<?php

namespace App;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class Item
{
    // items 是一個關聯陣列
    public $items;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldItems)
    {
        if ($oldItems) {
            $this->items      = $oldItems->items;
            $this->totalQty = $oldItems->totalQty;
            $this->totalPrice = $oldItems->totalPrice;
        }
    }

    public function add($item, $id)
    {
        // 存儲商品的初始狀態（數量為0，價格為商品價格，商品為物件）
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];

        // 檢查購物車是否有商品
        if ($this->items) {
            // 檢查購物車中是否有現有產品
            // 如果有，將 storedItem 設置為購物車項目
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }

        // storedItem 的數量增加一
        $storedItem['qty']++;
        // storedItem 的價格 = 當前商品的價格 * storedItem 的數量
        $storedItem['price'] = $item->price * $storedItem['qty'];
        // 使用 storedItem 更新當前商品
        $this->items[$id] = $storedItem;
        // 更新總數量
        $this->totalQty++;
        // 更新總價格
        $this->totalPrice += $item->price;
    }

    public function increaseByOne($id)
    {
        // 從 items 中根據 $id 獲取商品
        // 商品數量增加一
        $this->items[$id]['qty']++;
        // 更新商品價格
        $this->items[$id]['price'] += $this->items[$id]['item']['price'];
        // 更新總數量
        $this->totalQty++;
        // 更新總價格
        $this->totalPrice += $this->items[$id]['item']['price'];
    }

    public function decreaseByOne($id)
    {
        // 從 items 中根據 $id 獲取商品
        // 商品數量減少一
        $this->items[$id]['qty']--;
        // 更新商品價格
        $this->items[$id]['price'] -= $this->items[$id]['item']['price'];
        // 更新總數量
        $this->totalQty--;
        // 更新總價格
        $this->totalPrice -= $this->items[$id]['item']['price'];
        // 如果數量小於1，則刪除商品
        if ($this->items[$id]['qty'] < 1) {
            unset($this->items[$id]);
        }
    }

    public function removeItem($id)
    {
        // 從 items 中根據 $id 獲取商品
        // 更新總數量
        $this->totalQty -= $this->items[$id]['qty'];
        // 更新總價格
        $this->totalPrice -= $this->items[$id]['qty'] * $this->items[$id]['price'];
        // 刪除商品
        unset($this->items[$id]);
    }
}
