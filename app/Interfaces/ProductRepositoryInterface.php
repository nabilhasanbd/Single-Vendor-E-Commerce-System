<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    /**
     * Get all products.
     */
    public function getAll(): Collection;

    /**
     * Get a product by ID.
     */
    public function getById(int $id): ?Product;

    /**
     * Create a new product.
     */
    public function create(array $data): Product;

    /**
     * Update an existing product.
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a product.
     */
    public function delete(int $id): bool;
}
