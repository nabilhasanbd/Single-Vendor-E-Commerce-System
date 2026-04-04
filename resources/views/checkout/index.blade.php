<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout</title>
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
            --input-border: #d1d5db;
            --input-focus: #818cf8;
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
            max-width: 1200px;
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

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            font-weight: 500;
        }
        .alert-error ul { margin-top: 0.5rem; padding-left: 2rem; }

        .checkout-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .checkout-card {
            background: var(--card-bg);
            backdrop-filter: blur(15px);
            border-radius: var(--border-radius);
            box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 2.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 0.5rem;
        }

        /* Forms */
        .form-group { margin-bottom: 1.5rem; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-main);
        }

        input[type="text"] {
            width: 100%;
            padding: 0.85rem 1rem;
            border-radius: 8px;
            border: 1px solid var(--input-border);
            font-size: 1rem;
            color: var(--text-main);
            background: #f9fafb;
            outline: none;
            transition: var(--transition);
        }

        input[type="text"]:focus {
            border-color: var(--input-focus);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            background: #ffffff;
        }

        /* Payment Logic */
        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .payment-method {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 1px solid var(--input-border);
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        .payment-method:hover {
            border-color: var(--primary);
            background: #f8fafc;
        }

        .payment-method input {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid var(--text-muted);
            border-radius: 50%;
            margin-right: 1rem;
            position: relative;
        }

        .payment-method input:checked {
            border-color: var(--primary);
            background: var(--primary);
        }
        
        .disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Summary Panel */
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-weight: 500;
        }
        
        .summary-breakdown {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px dashed var(--text-muted);
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 2rem;
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 1.25rem;
            border: none;
            border-radius: 12px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            font-size: 1.15rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.39);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(236, 72, 153, 0.4);
        }

        @media (max-width: 900px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        
        <div class="nav-bar">
            <a href="{{ route('cart.index') }}" class="btn-back">← Back to Cart</a>
            <h1 class="page-title">Secure Checkout</h1>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <strong>Wait, something went wrong:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            
            <div class="checkout-grid">
                
                <!-- Left Column -->
                <div class="checkout-card">
                    <h2 class="section-title">1. Shipping Details</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', Auth::user()->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Street Address Line 1</label>
                        <input type="text" name="shipping_address_line1" value="{{ old('shipping_address_line1') }}" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Street Address Line 2 (Optional)</label>
                            <input type="text" name="shipping_address_line2" value="{{ old('shipping_address_line2') }}">
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" required>
                        </div>
                    </div>

                    <h2 class="section-title" style="margin-top: 2rem;">2. Payment Method</h2>
                    
                    <div class="payment-options">
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <div>
                                <strong>Cash on Delivery (COD)</strong>
                                <div style="font-size: 0.85rem; color: var(--text-muted);">Pay securely when the package arrives.</div>
                            </div>
                        </label>

                        <label class="payment-method disabled">
                            <!-- Currently passing sslcommerz as value but strictly simulated based on config -->
                            <input type="radio" name="payment_method" value="sslcommerz">
                            <div>
                                <strong>SSLCommerz (Online Payment)</strong>
                                <div style="font-size: 0.85rem; color: var(--secondary);">Routing configured. Secure redirect enabled.</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Right Column (Summary) -->
                <div class="checkout-card">
                    <h2 class="section-title">Order Summary</h2>
                    
                    <div class="summary-breakdown">
                        @foreach($cart->items as $item)
                        <div class="summary-item" style="font-size: 0.95rem;">
                            <span>{{ $item->quantity }}x {{ $item->product->name }}</span>
                            <span>${{ number_format($item->subtotal, 2) }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="summary-item" style="color: var(--text-muted)">
                        <span>Subtotal</span>
                        <span>${{ number_format($cart->total_amount, 2) }}</span>
                    </div>
                    <div class="summary-item" style="color: var(--text-muted)">
                        <span>Shipping</span>
                        <span>$0.00</span>
                    </div>

                    <div class="summary-total" style="margin-top: 1.5rem;">
                        <span>Total</span>
                        <span>${{ number_format($cart->total_amount, 2) }}</span>
                    </div>

                    <button type="submit" class="btn-submit">Confirm Order</button>
                    <div style="font-size: 0.8rem; text-align: center; color: var(--text-muted); margin-top: 1rem;">
                        By confirming, your cart will be cleared and product stock will drop.
                    </div>
                </div>

            </div>
        </form>

    </div>

</body>
</html>
