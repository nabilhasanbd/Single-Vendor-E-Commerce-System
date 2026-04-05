@extends('layouts.app')

@section('title', $order->order_number . ' — ' . config('app.name'))

@push('styles')
<style>
    :root { --primary: #6366f1; --card-bg: rgba(255, 255, 255, 0.95); }
    .order-detail-card { background: var(--card-bg); padding: 2rem; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); max-width: 900px; margin: 0 auto; }
    .order-header { display: flex; justify-content: space-between; border-bottom: 2px solid #f3f4f6; margin-bottom: 2rem; padding-bottom: 1rem; flex-wrap: wrap; gap: 1rem; }
    .badge-pill { background: #d1fae5; color: #059669; padding: 0.25rem 0.75rem; border-radius: 999px; font-weight: 600; }
    table { width: 100%; border-collapse: collapse; margin-top: 2rem; }
    th, td { padding: 1rem; border-bottom: 1px solid #f3f4f6; text-align: left; }
    .total-row { font-size: 1.5rem; font-weight: 700; color: var(--primary); text-align: right; margin-top: 1.5rem; }
</style>
@endpush

@section('content')
    <div class="order-detail-card">
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.orders.index') : route('orders.index') }}" class="d-inline-block mb-3 fw-semibold text-decoration-none">
            ← {{ auth()->user()->role === 'admin' ? 'All Orders' : 'My Orders' }}
        </a>

        <div class="order-header">
            <div>
                <h1 class="h3" style="color: var(--primary);">{{ $order->order_number }}</h1>
                <p class="text-muted mb-0">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
            </div>
            <div class="text-md-end">
                <div class="mb-1"><span class="badge-pill text-uppercase">Order: {{ $order->status }}</span></div>
                <div><span class="badge-pill text-uppercase" style="background:#fef3c7; color:#d97706;">Payment: {{ $order->payment_status }} ({{ strtoupper($order->payment_method) }})</span></div>
            </div>
        </div>

        <div class="bg-light p-3 rounded-3 mb-4">
            <strong>Shipping To:</strong><br>
            {{ $order->shipping_name }}<br>
            {{ $order->shipping_address_line1 }}, {{ $order->shipping_city }}<br>
            Phone: {{ $order->shipping_phone }}
        </div>

        <h3 class="h5 mb-3">Items Ordered</h3>
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
@endsection
