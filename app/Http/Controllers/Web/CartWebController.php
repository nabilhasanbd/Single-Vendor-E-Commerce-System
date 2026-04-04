<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Services\CartService;
use Exception;

class CartWebController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getUserCart();
        return view('cart.index', compact('cart'));
    }

    public function store(AddToCartRequest $request)
    {
        try {
            $this->cartService->addProductToCart($request->validated());
            return redirect()->route('cart.index')->with('success', 'Product added to your cart successfully!');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function update(UpdateCartRequest $request, int $id)
    {
        try {
            $this->cartService->updateItemQuantity($id, $request->input('quantity'));
            return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->cartService->removeCartItem($id);
            return redirect()->route('cart.index')->with('success', 'Item removed from your cart.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
