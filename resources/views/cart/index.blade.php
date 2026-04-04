<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
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
            align-items: flex-start;
            justify-content: center;
            padding: 4rem 2rem;
        }

        .container {
            width: 100%;
            max-width: 1100px;
        }

        .nav-bar {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-back {
            display: inline-flex;
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            background: var(--card-bg);
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }

        .btn-back:hover {
            color: var(--primary);
            transform: translateX(-5px);
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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

        .cart-card {
            background: var(--card-bg);
            backdrop-filter: blur(15px);
            border-radius: var(--border-radius);
            box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 3rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        th {
            text-align: left;
            padding-bottom: 1rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            border-bottom: 2px solid #f3f4f6;
        }

        td {
            padding: 1.5rem 0;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .product-img {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            background: #f8fafc;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }

        .product-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .qty-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .qty-input {
            width: 60px;
            padding: 0.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
            background: #f9fafb;
        }

        .btn-update {
            background: #f3f4f6;
            color: var(--text-main);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-update:hover {
            background: var(--primary);
            color: white;
        }

        .btn-remove {
            background: transparent;
            color: #ef4444;
            border: none;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-remove:hover {
            color: #b91c1c;
            text-decoration: underline;
        }

        .cart-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #f3f4f6;
        }

        .total-price {
            font-size: 2rem;
            font-weight: 700;
        }

        .btn-checkout {
            padding: 1.25rem 2.5rem;
            border: none;
            border-radius: 12px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.39);
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-checkout:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(236, 72, 153, 0.5);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state h3 {
            font-size: 1.75rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>

    <div class="container">
        
        <div class="nav-bar">
            <a href="{{ route('products.index') }}" class="btn-back">← Continue Shopping</a>
            <h1 class="page-title">Your Cart</h1>
        </div>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="cart-card">
            @if($cart && $cart->items->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart->items as $item)
                        <tr>
                            <td>
                                <div class="product-info">
                                    @if($item->product->image_url)
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="product-img">
                                    @else
                                        <div class="product-img" style="display:flex; align-items:center; justify-content:center; color:#94a3b8; font-size:0.8rem;">No Img</div>
                                    @endif
                                    <span class="product-name">{{ $item->product->name }}</span>
                                </div>
                            </td>
                            <td style="font-weight: 600; color: var(--text-muted);">${{ number_format($item->unit_price, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="qty-controls">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="qty-input">
                                    <button type="submit" class="btn-update">Update</button>
                                </form>
                            </td>
                            <td style="font-weight: 700; color: var(--text-main); font-size: 1.1rem">${{ number_format($item->subtotal, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove">Remove</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="cart-summary">
                    <div>
                        <span style="color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Estimated Total</span>
                        <div class="total-price">${{ number_format($cart->total_amount, 2) }}</div>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn-checkout">Proceed to Checkout</a>
                </div>
            @else
                <div class="empty-state">
                    <h3>Your cart is feeling a little empty.</h3>
                    <a href="{{ route('products.index') }}" class="btn-checkout">Browse Products</a>
                </div>
            @endif
        </div>

    </div>

</body>
</html>
