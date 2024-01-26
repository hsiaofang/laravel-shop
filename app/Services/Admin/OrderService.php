<?php

namespace App\Services\Admin;

use App\Repositories\Admin\OrderRepository;
use Illuminate\Support\Facades\Storage;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getAllOrders()
    {
        $orders = $this->orderRepository->getAllOrders();

        foreach ($orders as $order) {
            $cartData = json_decode($order->cart);

            if ($cartData && isset($cartData->items)) {
                $order->parsedCart = $cartData->items;
            }
        }

        return $orders;
    }
}