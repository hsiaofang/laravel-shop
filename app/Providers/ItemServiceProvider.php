<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Item;

class ItemServiceProvider extends ServiceProvider
{
    public function register()
    {
        // 在這裡進行 Item 類別的註冊
        $this->app->singleton('Item', function ($app) {
            return new Item(null); // 傳遞 null 或者其他需要的初始化資料
        });
    }
}
