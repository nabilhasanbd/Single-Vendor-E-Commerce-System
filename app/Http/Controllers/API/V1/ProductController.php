<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends BaseController
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of products.
     */
    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();
        
        return $this->successResponse(
            ProductResource::collection($products),
            'Products retrieved successfully.'
        );
    }

    /**
     * Store a newly created product.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct($request->validated());
        
        return $this->successResponse(
            new ProductResource($product),
            'Product created successfully.',
            201
        );
    }

    /**
     * Display the specified product.
     */
    public function show(int $id): JsonResponse
    {
        $product = $this->productService->getProductById($id);
        
        if (!$product) {
            return $this->errorResponse('Product not found.', 404);
        }
        
        return $this->successResponse(
            new ProductResource($product),
            'Product retrieved successfully.'
        );
    }

    /**
     * Update the specified product.
     */
    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $updated = $this->productService->updateProduct($id, $request->validated());
        
        if (!$updated) {
            return $this->errorResponse('Product not found or update failed.', 404);
        }

        // Fetch updated product
        $product = $this->productService->getProductById($id);
        
        return $this->successResponse(
            new ProductResource($product),
            'Product updated successfully.'
        );
    }

    /**
     * Remove the specified product.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->productService->deleteProduct($id);
        
        if (!$deleted) {
            return $this->errorResponse('Product not found or delete failed.', 404);
        }
        
        return $this->successResponse(
            null,
            'Product deleted successfully.'
        );
    }
}
