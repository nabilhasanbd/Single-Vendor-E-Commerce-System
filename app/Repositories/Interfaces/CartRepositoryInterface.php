<?php

namespace App\Repositories\Interfaces;

use App\Models\Cart;

interface CartRepositoryInterface
{
    public function getCartByUserId(int $userId): ?Cart;
    public function createCart(array $data): Cart;
    public function addOrUpdateItem(Cart $cart, array $data): void;
    public function updateItemQuantity(int $itemId, int $quantity): bool;
    public function removeItem(int $itemId): bool;
}
