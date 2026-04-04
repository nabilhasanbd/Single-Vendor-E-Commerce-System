<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Exception;

class ProductWebController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    // --- User Side ---

    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        $products = $this->productService->getActiveProducts(10, $categoryId);
        return view('products.index', compact('products'));
    }

    public function show(int $id)
    {
        $product = $this->productService->getProductById($id, true);
        if (!$product) {
            abort(404, 'Product not found');
        }
        return view('products.show', compact('product'));
    }

    // --- Admin Side ---

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $this->productService->createProduct($request->validated());
            return redirect()->route('admin.products.create')->with('success', 'Product created successfully.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit(int $id)
    {
        $product = $this->productService->getProductById($id);
        if (!$product) {
            abort(404, 'Product not found');
        }
        return view('admin.products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        try {
            $updated = $this->productService->updateProduct($id, $request->validated());
            if (!$updated) {
                return back()->withErrors(['error' => 'Product not found.']);
            }
            return redirect()->route('admin.products.edit', $id)->with('success', 'Product updated successfully.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->productService->deleteProduct($id);
            return redirect()->back()->with('success', 'Product deactivated successfully.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete product']);
        }
    }
}
