<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function getUserOrders(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Order::where('user_id', $userId)->latest()->paginate($perPage)->withQueryString();
    }

    public function getOrderByIdAndUser(int $orderId, int $userId): ?Order
    {
        return Order::with('items')->where('id', $orderId)->where('user_id', $userId)->first();
    }

    public function getAllOrders(int $perPage = 10): LengthAwarePaginator
    {
        return Order::with('user')->latest()->paginate($perPage)->withQueryString();
    }

    public function updateOrderStatus(int $orderId, string $status): Order
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => $status]);
        return $order;
    }

    public function getOrderById(int $orderId): ?Order
    {
        return Order::with(['items', 'user'])->find($orderId);
    }
}
