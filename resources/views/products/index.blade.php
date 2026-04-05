@extends('layouts.app')

@section('title', 'Shop — ' . config('app.name'))

@push('styles')
<style>
    :root {
        --primary: #6366f1;
        --primary-hover: #4f46e5;
        --secondary: #ec4899;
        --card-bg: rgba(255, 255, 255, 0.9);
        --text-main: #1f2937;
        --text-muted: #6b7280;
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .products-page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding: 1rem 2rem; background: var(--card-bg); border-radius: var(--border-radius); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .products-page-header h2 { font-size: 1.75rem; font-weight: 700; margin: 0; background: linear-gradient(to right, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .filter-section { background: var(--card-bg); border-radius: var(--border-radius); padding: 1.5rem 2rem; margin-bottom: 2rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); display: flex; flex-wrap: wrap; gap: 1.5rem; align-items: flex-end; }
    .filter-group { display: flex; flex-direction: column; gap: 0.5rem; flex: 1; min-width: 200px; }
    .filter-group label { font-size: 0.875rem; font-weight: 600; color: var(--text-muted); }
    .filter-input { padding: 0.75rem 1rem; border-radius: 10px; border: 1px solid #e5e7eb; font-size: 1rem; outline: none; transition: var(--transition); background: white; width: 100%; }
    .filter-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1); }
    .filter-actions { display: flex; gap: 0.75rem; }
    .btn-filter { background: var(--primary); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 600; cursor: pointer; transition: var(--transition); }
    .btn-filter:hover { background: var(--primary-hover); }
    .btn-reset { background: #f3f4f6; color: var(--text-main); border: 1px solid #e5e7eb; padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 600; text-decoration: none; transition: var(--transition); text-align: center; }
    .btn-reset:hover { background: #e5e7eb; }
    .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; max-width: 1400px; margin: 0 auto; }
    .product-card { background: var(--card-bg); border-radius: var(--border-radius); padding: 1.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); transition: var(--transition); border: 1px solid rgba(255, 255, 255, 0.5); display: flex; flex-direction: column; }
    .product-card:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border-color: rgba(99, 102, 241, 0.3); }
    .product-image-container { width: 100%; height: 200px; border-radius: 12px; overflow: hidden; margin-bottom: 1.5rem; background: #f8fafc; display: flex; align-items: center; justify-content: center; position: relative; }
    .product-image { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .product-card:hover .product-image { transform: scale(1.08); }
    .no-image { color: var(--text-muted); font-size: 0.9rem; font-weight: 500; }
    .product-title { font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-main); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .product-price { font-size: 1.5rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem; }
    .product-stock { font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }
    .stock-indicator { width: 8px; height: 8px; border-radius: 50%; background-color: #10b981; }
    .stock-indicator.out { background-color: #ef4444; }
    .btn-dashboard { text-decoration: none; color: white; background: var(--primary); padding: 0.75rem 1.5rem; border-radius: 999px; font-weight: 500; transition: var(--transition); box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.39); border: none; cursor: pointer; width: 100%; }
    .btn-dashboard:hover { background: var(--primary-hover); color: white; }
    .btn-outline { text-decoration: none; color: var(--text-main); background: transparent; padding: 0.75rem 1.5rem; border-radius: 999px; font-weight: 500; transition: var(--transition); border: 2px solid var(--primary); display: block; text-align: center; }
    .btn-outline:hover { background: var(--primary); color: white; }
    .no-products { grid-column: 1 / -1; text-align: center; padding: 4rem; background: var(--card-bg); border-radius: var(--border-radius); color: var(--text-muted); }
</style>
@endpush

@section('content')
    <div class="products-page-header">
        <h2>Explore Premium Collection</h2>
    </div>

    <form action="{{ route('products.index') }}" method="GET" class="filter-section">
        <div class="filter-group">
            <label for="search">Search Products</label>
            <input type="text" name="search" id="search" placeholder="Search by name..." value="{{ request('search') }}" class="filter-input">
        </div>
        <div class="filter-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="filter-input">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="filter-actions">
            <button type="submit" class="btn-filter">Filter</button>
            <a href="{{ route('products.index') }}" class="btn-reset">Reset</a>
        </div>
    </form>

    <div class="products-grid">
        @forelse ($products as $product)
            <div class="product-card">
                <div class="product-image-container">
                    @if ($product->image_url)
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="product-image">
                    @else
                        <span class="no-image">No Image</span>
                    @endif
                </div>
                <h3 class="product-title">{{ $product->name }}</h3>
                <p class="product-price">${{ number_format($product->price, 2) }}</p>
                <div class="product-stock">
                    <span class="stock-indicator {{ $product->stock > 0 ? '' : 'out' }}"></span>
                    {{ $product->stock > 0 ? 'In Stock (' . $product->stock . ')' : 'Out of Stock' }}
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-top: auto;">
                    @auth
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-dashboard" style="background: linear-gradient(to right, var(--primary), var(--secondary));">
                                Add to Cart
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-dashboard text-center" style="background: linear-gradient(to right, var(--primary), var(--secondary));">Login to Add to Cart</a>
                    @endauth
                    <a href="{{ route('products.show', $product->id) }}" class="btn-outline">View Details</a>
                </div>
            </div>
        @empty
            <div class="no-products">
                <h3>No products found</h3>
                <p>Try adjusting your search or filter to find what you're looking for.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $products->links() }}
    </div>
@endsection
