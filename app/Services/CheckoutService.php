<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Str;

class CheckoutService
{
    protected OrderRepositoryInterface $orderRepository;
    protected CartRepositoryInterface $cartRepository;
    protected PaymentService $paymentService;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CartRepositoryInterface $cartRepository,
        PaymentService $paymentService
    ) {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
        $this->paymentService = $paymentService;
    }

    public function placeOrder(int $userId, array $shippingData): array
    {
        $cart = $this->cartRepository->getCartByUserId($userId);

        if (!$cart || $cart->items->count() === 0) {
            throw new Exception("Cart is empty.");
        }

        return DB::transaction(function () use ($cart, $userId, $shippingData) {
            $totalAmount = 0;
            
            // 1. Validate Stock Constraints First
            foreach ($cart->items as $item) {
                $product = $item->product;
                if (!$product || !$product->is_active) {
                    throw new Exception("Product {$item->product_name} is unavailable.");
                }
                if ($item->quantity > $product->stock) {
                    throw new Exception("Insufficient stock for {$product->name}. Only {$product->stock} left.");
                }
                $totalAmount += ($item->unit_price * $item->quantity);
            }

            // 2. Create Order
            $orderNumber = 'ORD-' . date('Y') . '-' . strtoupper(Str::random(6));
            
            $order = $this->orderRepository->createOrder([
                'order_number' => $orderNumber,
                'user_id' => $userId,
                'shipping_name' => $shippingData['shipping_name'],
                'shipping_phone' => $shippingData['shipping_phone'],
                'shipping_address_line1' => $shippingData['shipping_address_line1'],
                'shipping_address_line2' => $shippingData['shipping_address_line2'] ?? null,
                'shipping_city' => $shippingData['shipping_city'],
                'subtotal' => $totalAmount,
                'total_amount' => $totalAmount, // Assuming no tax/shipping charge logic yet
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $shippingData['payment_method'],
            ]);

            // 3. Create Items & Deduct Stock
            foreach ($cart->items as $item) {
                $product = $item->product;
                
                $this->orderRepository->createOrderItem([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_image' => $product->image_url,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->unit_price * $item->quantity,
                ]);

                // Deduct safely
                $product->stock -= $item->quantity;
                $product->save();
            }

            // 4. Create Payment Profile
            $this->orderRepository->createPayment([
                'order_id' => $order->id,
                'user_id' => $userId,
                'payment_method' => $shippingData['payment_method'],
                'amount' => $totalAmount,
                'status' => 'pending',
            ]);

            // 5. Clear Cart (Delete Items)
            foreach ($cart->items as $item) {
                $this->cartRepository->removeItem($item->id);
            }

            // 6. Handle Payment Routing Decision
            if ($shippingData['payment_method'] === 'cod') {
                return [
                    'redirect_url' => route('orders.show', $order->id),
                    'message' => 'Order placed successfully via Cash on Delivery.'
                ];
            } else {
                // Return SSLCommerz routing portal
                $paymentUrl = $this->paymentService->createSslPaymentSession($order);
                return [
                    'redirect_url' => $paymentUrl,
                    'message' => 'Redirecting to secure payment gateway...'
                ];
            }
        });
    }

    public function getUserOrders(int $userId)
    {
        return $this->orderRepository->getUserOrders($userId);
    }
    
    public function getOrder(int $orderId, int $userId)
    {
        return $this->orderRepository->getOrderByIdAndUser($orderId, $userId);
    }
}
