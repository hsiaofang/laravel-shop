<?php

namespace App\Repositories\Admin;

use App\Models\Order;

class OrderRepository
{
    public function getAllOrders()
    {
        return Order::all();
    }
}