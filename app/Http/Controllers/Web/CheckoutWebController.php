<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\PlaceOrderRequest;
use App\Services\CartService;
use App\Services\CheckoutService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutWebController extends Controller
{
    protected CheckoutService $checkoutService;
    protected CartService $cartService;

    public function __construct(CheckoutService $checkoutService, CartService $cartService)
    {
        $this->checkoutService = $checkoutService;
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getUserCart();
        if ($cart->items->count() === 0) {
            return redirect()->route('cart.index')->withErrors(['error' => 'Your cart is empty.']);
        }
        return view('checkout.index', compact('cart'));
    }

    public function store(PlaceOrderRequest $request)
    {
        try {
            $result = $this->checkoutService->placeOrder(Auth::id(), $request->validated());
            return redirect()->to($result['redirect_url'])->with('success', $result['message']);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function orders()
    {
        $orders = $this->checkoutService->getUserOrders(Auth::id());
        return view('orders.index', compact('orders'));
    }

    public function showOrder(int $id)
    {
        $order = Auth::user()->role === 'admin' 
            ? $this->checkoutService->getOrderById($id) 
            : $this->checkoutService->getOrder($id, Auth::id());

        if (!$order) {
            abort(404, 'Order not found or unauthorized access.');
        }
        return view('orders.show', compact('order'));
    }

    public function adminOrders()
    {
        $orders = $this->checkoutService->getAllOrders();
        return view('orders.index', compact('orders'));
    }

    public function updateOrderStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $this->checkoutService->updateOrderStatus($id, $request->status);

        return back()->with('success', 'Order status updated successfully.');
    }

    // SSLCommerz Web Hooks (Placeholders)
    public function sslSuccess(Request $request)
    {
        return "Payment Success! (Placeholder route for SSLCommerz). Order ID: " . $request->query('order_id');
    }

    public function sslFail()
    {
        return "Payment Failed! (Placeholder)";
    }

    public function sslCancel()
    {
        return "Payment Cancelled! (Placeholder)";
    }
}
