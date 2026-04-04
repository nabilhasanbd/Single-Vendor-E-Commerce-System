<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Details</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --secondary: #ec4899;
            --bg-gradient: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            --card-bg: rgba(255, 255, 255, 0.95);
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border-radius: 20px;
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .container {
            width: 100%;
            max-width: 1100px;
        }

        /* Top Navigation */
        .nav-bar {
            margin-bottom: 2rem;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            background: var(--card-bg);
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .btn-back:hover {
            color: var(--primary);
            transform: translateX(-5px);
            box-shadow: 0 6px 10px -1px rgba(0, 0, 0, 0.1);
        }

        /* Product Main Card */
        .product-wrapper {
            background: var(--card-bg);
            backdrop-filter: blur(15px);
            border-radius: var(--border-radius);
            box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.1), 0 10px 15px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.4);
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 500px;
        }

        /* Image Side */
        .image-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
        }

        .product-image {
            max-width: 100%;
            max-height: 400px;
            object-fit: contain;
            border-radius: 12px;
            transition: transform 0.5s ease;
            filter: drop-shadow(0 20px 20px rgba(0,0,0,0.15));
        }

        .image-section:hover .product-image {
            transform: scale(1.05);
        }

        .no-image {
            color: #94a3b8;
            font-size: 1.25rem;
            font-weight: 500;
        }

        /* Details Side */
        .details-section {
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .category-badge {
            display: inline-block;
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
            padding: 0.35rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
            align-self: flex-start;
        }

        .product-title {
            font-size: 2.75rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1rem;
            color: var(--text-main);
        }

        .product-price {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stock-badge {
            font-size: 0.9rem;
            padding: 0.4rem 1rem;
            border-radius: 8px;
            font-weight: 600;
        }

        .stock-good { background: #d1fae5; color: #059669; }
        .stock-low  { background: #fef3c7; color: #d97706; }
        .stock-out  { background: #fee2e2; color: #dc2626; }

        .product-desc {
            font-size: 1.1rem;
            line-height: 1.6;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
        }

        .action-area {
            margin-top: auto;
            border-top: 1px solid #f3f4f6;
            padding-top: 2rem;
            display: flex;
            gap: 1rem;
        }

        .btn-cart {
            flex: 1;
            padding: 1.25rem;
            border: none;
            border-radius: 12px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.39);
        }

        .btn-cart:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(236, 72, 153, 0.5);
        }

        @media (max-width: 900px) {
            .product-wrapper {
                grid-template-columns: 1fr;
            }
            .details-section {
                padding: 2.5rem;
            }
            .product-image {
                max-height: 250px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        
        <div class="nav-bar">
            <a href="{{ route('products.index') }}" class="btn-back">
                ← Back to Catalog
            </a>
        </div>

        <div class="product-wrapper">
            
            <div class="image-section">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <div class="no-image">No Image Available</div>
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
                    {{ $product->description ?? 'No detailed description available for this awesome product.' }}
                </div>

                <div class="action-area">
                    <form action="{{ route('cart.store') }}" method="POST" style="width:100%; display:flex;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-cart">Add to Cart</button>
                    </form>
                </div>

            </div>

        </div>
    </div>

</body>
</html>
