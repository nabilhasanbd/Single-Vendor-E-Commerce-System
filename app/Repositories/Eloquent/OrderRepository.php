<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder(array $data): Order
    {
        return Order::create($data);
    }

    public function createOrderItem(array $data): void
    {
        OrderItem::create($data);
    }

    public function createPayment(array $data): void
    {
        Payment::create($data);
    }

    public function getUserOrders(int $userId)
    {
        return Order::where('user_id', $userId)->latest()->get();
    }

    public function getOrderByIdAndUser(int $orderId, int $userId): ?Order
    {
        return Order::with('items')->where('id', $orderId)->where('user_id', $userId)->first();
    }
}
