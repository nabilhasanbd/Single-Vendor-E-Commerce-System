<?php

namespace App\Repositories\Eloquent;

use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\Interfaces\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    public function getCartByUserId(int $userId): ?Cart
    {
        return Cart::with('items.product')->where('user_id', $userId)->first();
    }

    public function createCart(array $data): Cart
    {
        return Cart::create($data);
    }

    public function addOrUpdateItem(Cart $cart, array $data): void
    {
        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $data['product_id'])
            ->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $data['quantity'] // In service we will add them up explicitly
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'unit_price' => $data['unit_price']
            ]);
        }
    }

    public function updateItemQuantity(int $itemId, int $quantity): bool
    {
        $item = CartItem::find($itemId);
        if ($item) {
            return $item->update(['quantity' => $quantity]);
        }
        return false;
    }

    public function removeItem(int $itemId): bool
    {
        $item = CartItem::find($itemId);
        if ($item) {
            return $item->delete();
        }
        return false;
    }
}
