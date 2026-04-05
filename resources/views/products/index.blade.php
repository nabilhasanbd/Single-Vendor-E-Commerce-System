<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Products</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --secondary: #ec4899;
            --bg-gradient: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            --card-bg: rgba(255, 255, 255, 0.9);
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: var(--bg-gradient);
            color: var(--text-main);
            min-height: 100vh;
            padding: 2rem;
        }

        /* Header Sequence */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
            padding: 1rem 2rem;
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .header h2 {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-dashboard {
            text-decoration: none;
            color: white;
            background: var(--primary);
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            font-weight: 500;
            transition: var(--transition);
            box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.39);
        }

        .btn-dashboard:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .btn-outline {
            text-decoration: none;
            color: var(--text-main);
            background: transparent;
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            font-weight: 500;
            transition: var(--transition);
            border: 2px solid var(--primary);
            margin-right: 0.5rem;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            font-weight: 500;
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }
        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border-color: #ef4444;
        }

        /* Grid Layout */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Product Card */
        .product-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.5);
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(10px);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: rgba(99, 102, 241, 0.3);
        }

        /* Image Handling */
        .product-image-container {
            width: 100%;
            height: 200px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1.5rem;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.08);
        }

        .no-image {
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Card Content */
        .product-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-main);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .product-stock {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stock-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #10b981; /* Default to Green */
        }
        
        .stock-indicator.low {
            background-color: #f59e0b; /* Yellow for low stock */
        }
        
        .stock-indicator.out {
            background-color: #ef4444; /* Red for out of stock */
        }

        /* Actions */
        .product-action {
            margin-top: auto;
        }

        .btn-view {
            display: block;
            width: 100%;
            text-align: center;
            text-decoration: none;
            background: linear-gradient(to right, #f9fafb, #f3f4f6);
            color: var(--text-main);
            border: 1px solid #e5e7eb;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
        }

        .product-card:hover .btn-view {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border-color: transparent;
        }

        /* Pagination Styling */
        .pagination-container {
            margin-top: 4rem;
            display: flex;
            justify-content: center;
        }
        
        /* Laravel naturally injects styling, but this tries to clean it if default blade links are used */
        .pagination-container nav {
            background: var(--card-bg);
            padding: 1rem 2rem;
            border-radius: 999px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Explore Premium Collection</h2>
        <div class="nav-links">
            @guest
                <a href="{{ route('login') }}" class="btn-outline">Login</a>
                <a href="{{ route('register') }}" class="btn-dashboard">Register</a>
            @endguest
            @auth
                <a href="{{ route('cart.index') }}" class="btn-outline">Cart</a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-dashboard" style="border:none; cursor:pointer; font-family: 'Outfit', sans-serif; font-size: 1rem;">Logout</button>
                </form>
            @endauth
        </div>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="products-grid">
        @forelse($products as $product)
            <div class="product-card">
                <div class="product-image-container">
                    @if($product->image_url)
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="product-image">
                    @else
                        <span class="no-image">Image not available</span>
                    @endif
                </div>
                
                <h3 class="product-title">{{ $product->name }}</h3>
                <div class="product-price">${{ number_format($product->price, 2) }}</div>
                
                <div class="product-stock">
                    @if($product->stock > 5)
                        <span class="stock-indicator"></span> {{ $product->stock }} in stock
                    @elseif($product->stock > 0)
                        <span class="stock-indicator low"></span> Only {{ $product->stock }} left!
                    @else
                        <span class="stock-indicator out"></span> Out of Stock
                    @endif
                </div>

                <div class="product-action" style="display: flex; gap: 0.5rem; flex-direction: column;">
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-view" style="background: linear-gradient(to right, var(--primary), var(--secondary)); color: white; border-color: transparent;">Add to Cart</button>
                    </form>
                    <a href="{{ route('products.show', $product->id) }}" class="btn-view">
                        View Details
                    </a>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; color: var(--text-muted); background: var(--card-bg); border-radius: 16px;">
                <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">No products found</h3>
                <p>Check back later for new arrivals.</p>
            </div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="pagination-container">
            {{ $products->links('pagination::bootstrap-4') }} <!-- Force bootstrap 4 styling markup temporarily to play nice with generic CSS or default blades fallback -->
        </div>
    @endif

</body>
</html>
