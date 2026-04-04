<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Checkout\PlaceOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\CheckoutService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends BaseController
{
    protected CheckoutService $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function store(PlaceOrderRequest $request): JsonResponse
    {
        try {
            $result = $this->checkoutService->placeOrder(Auth::id(), $request->validated());
            return $this->successResponse($result, $result['message'], 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function index(): JsonResponse
    {
        $orders = $this->checkoutService->getUserOrders(Auth::id());
        return $this->successResponse(OrderResource::collection($orders)->response()->getData(true), 'Orders retrieved.');
    }

    public function show(int $id): JsonResponse
    {
        $order = $this->checkoutService->getOrder($id, Auth::id());
        if (!$order) {
            return $this->errorResponse('Order not found', 404);
        }
        return $this->successResponse(new OrderResource($order), 'Order details retrieved.');
    }
}
