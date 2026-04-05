<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use Exception;

class ProductWebController extends Controller
{
    protected ProductService $productService;
    protected CategoryService $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
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
        $categories = $this->categoryService->getAllActiveCategories();
        
        if ($categories->isEmpty()) {
            return redirect()->route('admin.categories.create')->with('error', 'You must create a category before adding a product!');
        }

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('image')) {
                $data['image_url'] = $request->file('image')->store('products', 'public');
            }
            unset($data['image']);
            
            $this->productService->createProduct($data);
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
        $categories = $this->categoryService->getAllActiveCategories();
        
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('image')) {
                $data['image_url'] = $request->file('image')->store('products', 'public');
            }
            unset($data['image']);
            
            $updated = $this->productService->updateProduct($id, $data);
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
