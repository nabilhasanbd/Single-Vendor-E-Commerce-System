<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function getAllActivePaginated(int $perPage = 15, ?int $categoryId = null): LengthAwarePaginator;
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;
    public function getById(int $id): ?Product;
    public function create(array $data): Product;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
