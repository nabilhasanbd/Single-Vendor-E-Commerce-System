<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #6366f1; --card-bg: rgba(255, 255, 255, 0.95); --text-main: #1f2937; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); padding: 4rem 2rem; display: flex; justify-content: center; }
        .container { width: 100%; max-width: 900px; background: var(--card-bg); padding: 3rem; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #f3f4f6; margin-bottom: 2rem; padding-bottom: 1rem; }
        .badge { background: #d1fae5; color: #059669; padding: 0.25rem 0.75rem; border-radius: 999px; font-weight: 600;}
        table { width: 100%; border-collapse: collapse; margin-top: 2rem; }
        th, td { padding: 1rem; border-bottom: 1px solid #f3f4f6; text-align: left;}
        .total-row { font-size: 1.5rem; font-weight: 700; color: var(--primary); text-align: right; margin-top: 1.5rem;}
        .alert { padding: 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 2rem; }
    </style>
</head>
<body>
    <div class="container">
        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <a href="{{ route('orders.index') }}" style="display:inline-block; margin-bottom: 1rem; color: var(--primary); font-weight:600; text-decoration: none;">← My Orders</a>
        
        <div class="header">
            <div>
                <h1 style="color: var(--primary);">{{ $order->order_number }}</h1>
                <p style="color: #6b7280;">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
            </div>
            <div style="text-align: right;">
                <div style="margin-bottom: 0.5rem;"><span class="badge" style="text-transform: uppercase;">Order: {{ $order->status }}</span></div>
                <div><span class="badge" style="background:#fef3c7; color:#d97706; text-transform: uppercase;">Payment: {{ $order->payment_status }} ({{ strtoupper($order->payment_method) }})</span></div>
            </div>
        </div>

        <div style="background: #f9fafb; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem;">
            <strong>Shipping To:</strong><br>
            {{ $order->shipping_name }}<br>
            {{ $order->shipping_address_line1 }}, {{ $order->shipping_city }}<br>
            Phone: {{ $order->shipping_phone }}
        </div>

        <h3>Items Ordered</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>${{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td><strong>${{ number_format($item->total_price, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-row">
            Grand Total: ${{ number_format($order->total_amount, 2) }}
        </div>
    </div>
</body>
</html>
