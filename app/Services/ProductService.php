<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ProductService
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Get all products.
     */
    public function getAllProducts(): Collection
    {
        return $this->productRepository->getAll();
    }

    /**
     * Get a single product by ID.
     */
    public function getProductById(int $id): ?Product
    {
        return $this->productRepository->getById($id);
    }

    /**
     * Create a new product.
     */
    public function createProduct(array $data): Product
    {
        // Business logic: Generate slug if not provided
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        // Any other business logic goes here before saving
        
        return $this->productRepository->create($data);
    }

    /**
     * Update an existing product.
     */
    public function updateProduct(int $id, array $data): bool
    {
        // Business logic: Update slug if name gets updated
        if (isset($data['name']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $this->productRepository->update($id, $data);
    }

    /**
     * Delete a product.
     */
    public function deleteProduct(int $id): bool
    {
        // Check if product can be deleted (e.g. check open orders here)
        
        return $this->productRepository->delete($id);
    }
}
