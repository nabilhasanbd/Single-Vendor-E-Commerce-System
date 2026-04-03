<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Get all products.
     */
    public function getAll(): Collection
    {
        return Product::all();
    }

    /**
     * Get a product by ID.
     */
    public function getById(int $id): ?Product
    {
        return Product::find($id);
    }

    /**
     * Create a new product.
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * Update an existing product.
     */
    public function update(int $id, array $data): bool
    {
        $product = Product::find($id);
        
        if (!$product) {
            return false;
        }
        
        return $product->update($data);
    }

    /**
     * Delete a product.
     */
    public function delete(int $id): bool
    {
        $product = Product::find($id);
        
        if (!$product) {
            return false;
        }
        
        return $product->delete();
    }
}
