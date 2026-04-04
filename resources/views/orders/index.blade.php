<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --bg-gradient: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            --card-bg: rgba(255, 255, 255, 0.95);
            --text-main: #1f2937;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background: var(--bg-gradient); padding: 4rem 2rem; display: flex; justify-content: center; }
        .container { width: 100%; max-width: 1000px; background: var(--card-bg); padding: 3rem; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); }
        h1 { margin-bottom: 2rem; color: var(--primary); }
        .order-card { padding: 1.5rem; border: 1px solid #e5e7eb; border-radius: 12px; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center; }
        .badge { background: #d1fae5; color: #059669; padding: 0.25rem 0.75rem; border-radius: 999px; font-weight: 600; font-size: 0.85rem;}
        .btn-view { background: #f3f4f6; color: var(--text-main); text-decoration: none; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; }
        .btn-view:hover { background: var(--primary); color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Order History</h1>
        <a href="/dashboard" style="display:inline-block; margin-bottom: 2rem; color: var(--primary); font-weight:600; text-decoration: none;">← Back to Dash</a>

        @forelse($orders as $order)
            <div class="order-card">
                <div>
                    <h3 style="margin-bottom: 0.5rem;">{{ $order->order_number }}</h3>
                    <div style="color: #6b7280; font-size: 0.9rem;">Placed on {{ $order->created_at->format('M d, Y') }}</div>
                </div>
                <div>
                    <span class="badge" style="margin-right: 1.5rem; text-transform:uppercase;">Status: {{ $order->status }}</span>
                    <strong style="margin-right: 1.5rem;">${{ number_format($order->total_amount, 2) }}</strong>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn-view">View Details</a>
                </div>
            </div>
        @empty
            <p>You haven't placed any orders yet.</p>
        @endforelse
    </div>
</body>
</html>
