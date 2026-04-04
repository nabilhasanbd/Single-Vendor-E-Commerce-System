<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use Exception;
use Illuminate\Http\JsonResponse;

class CartController extends BaseController
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): JsonResponse
    {
        try {
            $cart = $this->cartService->getUserCart();
            return $this->successResponse(new CartResource($cart), 'Cart retrieved successfully.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function store(AddToCartRequest $request): JsonResponse
    {
        try {
            $this->cartService->addProductToCart($request->validated());
            $cart = $this->cartService->getUserCart();
            return $this->successResponse(new CartResource($cart), 'Product added to cart successfully.', 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function update(UpdateCartRequest $request, int $id): JsonResponse
    {
        try {
            $this->cartService->updateItemQuantity($id, $request->input('quantity'));
            $cart = $this->cartService->getUserCart();
            return $this->successResponse(new CartResource($cart), 'Cart quantity updated successfully.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->cartService->removeCartItem($id);
            $cart = $this->cartService->getUserCart();
            return $this->successResponse(new CartResource($cart), 'Item removed from cart.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
}
