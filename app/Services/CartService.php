<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;

class CartService
{
    protected CartRepositoryInterface $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getUserCart(): Cart
    {
        $userId = Auth::id();
        $cart = $this->cartRepository->getCartByUserId($userId);

        if (!$cart) {
            $cart = $this->cartRepository->createCart(['user_id' => $userId]);
        }

        return $cart;
    }

    public function addProductToCart(array $data): void
    {
        $product = Product::find($data['product_id']);

        if (!$product || !$product->is_active) {
            throw new Exception("Product is currently unavailable.");
        }

        $cart = $this->getUserCart();

        // Check if item already exists to calculate total quantity requested
        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        $newQuantity = $existingItem ? $existingItem->quantity + $data['quantity'] : $data['quantity'];

        if ($newQuantity > $product->stock) {
            throw new Exception("Requested quantity exceeds available stock (Stock: {$product->stock}).");
        }

        $this->cartRepository->addOrUpdateItem($cart, [
            'product_id' => $product->id,
            'quantity' => $newQuantity,
            'unit_price' => $product->price
        ]);
    }

    public function updateItemQuantity(int $itemId, int $quantity): void
    {
        $item = CartItem::find($itemId);
        if (!$item) {
            throw new Exception("Cart item not found.");
        }

        $product = Product::find($item->product_id);
        if ($quantity > $product->stock) {
            throw new Exception("Requested quantity exceeds available stock (Stock: {$product->stock}).");
        }

        $this->cartRepository->updateItemQuantity($itemId, $quantity);
    }

    public function removeCartItem(int $itemId): void
    {
        $this->cartRepository->removeItem($itemId);
    }
}
