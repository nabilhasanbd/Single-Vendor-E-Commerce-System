<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function createOrder(array $data): Order;
    public function createOrderItem(array $data): void;
    public function createPayment(array $data): void;
    public function getUserOrders(int $userId, int $perPage = 10): LengthAwarePaginator;
    public function getOrderByIdAndUser(int $orderId, int $userId): ?Order;
    public function getAllOrders(int $perPage = 10): LengthAwarePaginator;
    public function updateOrderStatus(int $orderId, string $status): Order;
    public function getOrderById(int $orderId): ?Order;
}
