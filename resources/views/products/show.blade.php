@extends('layouts.app')

@section('title', $product->name . ' — ' . config('app.name'))

@push('styles')
<style>
    :root {
        --primary: #6366f1;
        --primary-hover: #4f46e5;
        --secondary: #ec4899;
        --card-bg: rgba(255, 255, 255, 0.95);
        --text-main: #1f2937;
        --text-muted: #6b7280;
        --border-radius: 20px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .product-wrapper { background: var(--card-bg); border-radius: var(--border-radius); box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.4); display: grid; grid-template-columns: 1fr 1fr; min-height: 500px; max-width: 1100px; margin: 0 auto; overflow: hidden; }
    .image-section { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); display: flex; align-items: center; justify-content: center; padding: 3rem; }
    .product-image { max-width: 100%; max-height: 400px; object-fit: contain; border-radius: 12px; }
    .details-section { padding: 4rem 3rem; display: flex; flex-direction: column; justify-content: center; }
    .category-badge { display: inline-block; background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 0.35rem 1rem; border-radius: 999px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; margin-bottom: 1rem; }
    .product-title { font-size: 2.5rem; font-weight: 700; line-height: 1.1; margin-bottom: 1rem; color: var(--text-main); }
    .product-price { font-size: 2.25rem; font-weight: 700; color: var(--primary); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .stock-badge { font-size: 0.9rem; padding: 0.4rem 1rem; border-radius: 8px; font-weight: 600; }
    .stock-good { background: #d1fae5; color: #059669; }
    .stock-low { background: #fef3c7; color: #d97706; }
    .stock-out { background: #fee2e2; color: #dc2626; }
    .product-desc { font-size: 1.1rem; line-height: 1.6; color: var(--text-muted); margin-bottom: 2.5rem; }
    .btn-cart { width: 100%; padding: 1.25rem; border: none; border-radius: 12px; background: linear-gradient(to right, var(--primary), var(--secondary)); color: white; font-size: 1.1rem; font-weight: 700; cursor: pointer; box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.39); }
    .btn-cart:hover { transform: translateY(-2px); }
    @media (max-width: 900px) {
        .product-wrapper { grid-template-columns: 1fr; }
        .details-section { padding: 2.5rem; }
        .product-image { max-height: 250px; }
    }
</style>
@endpush

@section('content')
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="text-decoration-none fw-semibold text-muted">← Back to catalog</a>
    </div>

    <div class="product-wrapper">
        <div class="image-section">
            @if($product->image_url)
                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="product-image">
            @else
                <div class="text-secondary fs-5">No Image Available</div>
            @endif
        </div>
        <div class="details-section">
            <span class="category-badge">Category #{{ $product->category_id }}</span>
            <h1 class="product-title">{{ $product->name }}</h1>
            <div class="product-price">
                ${{ number_format($product->price, 2) }}
                @if($product->stock > 5)
                    <span class="stock-badge stock-good">{{ $product->stock }} in stock</span>
                @elseif($product->stock > 0)
                    <span class="stock-badge stock-low">Only {{ $product->stock }} left</span>
                @else
                    <span class="stock-badge stock-out">Out of Stock</span>
                @endif
            </div>
            <div class="product-desc">
                {{ $product->description ?? 'No detailed description available for this product.' }}
            </div>
            <div class="mt-auto pt-4 border-top">
                @auth
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-cart" {{ $product->stock < 1 ? 'disabled' : '' }}>Add to Cart</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-cart d-block text-center text-decoration-none">Login to Add to Cart</a>
                @endauth
            </div>
        </div>
    </div>
@endsection
