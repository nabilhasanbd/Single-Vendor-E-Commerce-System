<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class ProductController extends BaseController
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    // --- Public Routes ---

    public function index(Request $request): JsonResponse
    {
        try {
            $categoryId = $request->query('category_id');
            $products = $this->productService->getActiveProducts(15, $categoryId);
            
            return $this->successResponse(
                ProductResource::collection($products)->response()->getData(true),
                'Products retrieved successfully.'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve products', 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->productService->getProductById($id, true);
        
        if (!$product) {
            return $this->errorResponse('Product not found.', 404);
        }
        
        return $this->successResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    // --- Admin Routes ---

    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $product = $this->productService->createProduct($request->validated());
            
            return $this->successResponse(new ProductResource($product), 'Product created successfully.', 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        try {
            $updated = $this->productService->updateProduct($id, $request->validated());
            
            if (!$updated) {
                return $this->errorResponse('Product not found.', 404);
            }

            $product = $this->productService->getProductById($id);
            return $this->successResponse(new ProductResource($product), 'Product updated successfully.');

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->productService->deleteProduct($id);
            
            if (!$deleted) {
                return $this->errorResponse('Product not found.', 404);
            }
            
            return $this->successResponse(null, 'Product deleted successfully.');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to delete product', 500);
        }
    }
}
