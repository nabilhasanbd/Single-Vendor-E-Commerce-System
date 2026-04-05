@extends('layouts.app')

@section('title', (auth()->user()->role === 'admin' ? 'All orders' : 'My orders') . ' — ' . config('app.name'))

@push('styles')
<style>
    :root { --primary: #6366f1; --card-bg: rgba(255, 255, 255, 0.95); --text-main: #1f2937; }
    .order-card { padding: 1.5rem; border: 1px solid #e5e7eb; border-radius: 12px; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; background: var(--card-bg); }
    .badge-soft { background: #d1fae5; color: #059669; padding: 0.25rem 0.75rem; border-radius: 999px; font-weight: 600; font-size: 0.85rem; }
    .btn-view { background: #f3f4f6; color: var(--text-main); text-decoration: none; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; }
    .btn-view:hover { background: var(--primary); color: white; }
</style>
@endpush

@section('content')
    <h1 class="h3 mb-4" style="color: var(--primary);">{{ auth()->user()->role === 'admin' ? 'Manage All Orders' : 'My Order History' }}</h1>
    <a href="{{ route('dashboard') }}" class="d-inline-block mb-4 fw-semibold text-decoration-none">← Back to dashboard</a>

    @forelse($orders as $order)
        <div class="order-card">
            <div>
                <h3 class="h5 mb-1">{{ $order->order_number }}</h3>
                <div class="text-muted small">
                    Placed on {{ $order->created_at->format('M d, Y') }}
                    @if(auth()->user()->role === 'admin')
                        by {{ $order->user->name }} ({{ $order->user->email }})
                    @endif
                </div>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                @if(auth()->user()->role === 'admin')
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-flex align-items-center">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                @else
                    <span class="badge-soft text-uppercase">Status: {{ $order->status }}</span>
                @endif
                <strong>${{ number_format($order->total_amount, 2) }}</strong>
                <a href="{{ route('orders.show', $order->id) }}" class="btn-view">View Details</a>
            </div>
        </div>
    @empty
        <p class="text-muted">{{ auth()->user()->role === 'admin' ? 'No orders found in the system.' : "You haven't placed any orders yet." }}</p>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
@endsection
