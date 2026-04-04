<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function createOrder(array $data): Order;
    public function createOrderItem(array $data): void;
    public function createPayment(array $data): void;
    public function getUserOrders(int $userId);
    public function getOrderByIdAndUser(int $orderId, int $userId): ?Order;
}
