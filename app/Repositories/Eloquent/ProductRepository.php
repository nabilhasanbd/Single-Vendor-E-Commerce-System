<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllActivePaginated(int $perPage = 15, ?int $categoryId = null, ?string $search = null): LengthAwarePaginator
    {
        return Product::where('is_active', true)
            ->when($categoryId, function ($query) use ($categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'LIKE', '%' . $search . '%');
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Product::latest()->paginate($perPage)->withQueryString();
    }

    public function getById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $product = Product::find($id);
        if (!$product) {
            return false;
        }
        return $product->update($data);
    }

    public function delete(int $id): bool
    {
        $product = Product::find($id);
        if (!$product) {
            return false;
        }
        
        // Soft deleting
        $product->is_active = false;
        $product->save();
        return $product->delete();
    }
}
