<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use InvalidArgumentException;

class ProductService
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getActiveProducts(int $perPage = 15, ?int $categoryId = null, ?string $search = null): LengthAwarePaginator
    {
        return $this->productRepository->getAllActivePaginated($perPage, $categoryId, $search);
    }

    public function getAllProducts(int $perPage = 15): LengthAwarePaginator
    {
        return $this->productRepository->getAllPaginated($perPage);
    }

    public function getProductById(int $id, bool $activeOnly = false): ?Product
    {
        $product = $this->productRepository->getById($id);
        
        if ($activeOnly && $product && !$product->is_active) {
            return null;
        }

        return $product;
    }

    public function createProduct(array $data): Product
    {
        $this->validateBusinessRules($data);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        $data['is_active'] = $data['is_active'] ?? true;

        return $this->productRepository->create($data);
    }

    public function updateProduct(int $id, array $data): bool
    {
        $this->validateBusinessRules($data);

        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct(int $id): bool
    {
        return $this->productRepository->delete($id);
    }

    /**
     * Enforce core business logic
     */
    private function validateBusinessRules(array $data): void
    {
        if (isset($data['price']) && $data['price'] < 0) {
            throw new InvalidArgumentException("Product price cannot be negative.");
        }

        if (isset($data['stock']) && $data['stock'] < 0) {
            throw new InvalidArgumentException("Product stock cannot be negative.");
        }
    }
}
