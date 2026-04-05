@extends('layouts.app')

@section('title', 'Your Cart — ' . config('app.name'))

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
    .cart-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
    .btn-back { display: inline-flex; text-decoration: none; color: var(--text-muted); font-weight: 600; background: var(--card-bg); padding: 0.75rem 1.5rem; border-radius: 999px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .btn-back:hover { color: var(--primary); }
    .page-title { font-size: 2rem; font-weight: 700; margin: 0; background: linear-gradient(to right, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .cart-card { background: var(--card-bg); border-radius: var(--border-radius); box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.4); padding: 3rem; max-width: 1100px; margin: 0 auto; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
    th { text-align: left; padding-bottom: 1rem; color: var(--text-muted); text-transform: uppercase; font-size: 0.85rem; border-bottom: 2px solid #f3f4f6; }
    td { padding: 1.5rem 0; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
    .product-info { display: flex; align-items: center; gap: 1.5rem; }
    .product-img { width: 80px; height: 80px; border-radius: 12px; object-fit: cover; background: #f8fafc; }
    .product-name { font-size: 1.2rem; font-weight: 600; color: var(--text-main); }
    .qty-controls { display: flex; align-items: center; gap: 0.5rem; }
    .qty-input { width: 60px; padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 8px; text-align: center; font-weight: 600; background: #f9fafb; }
    .btn-remove { background: transparent; color: #ef4444; border: none; font-size: 0.9rem; font-weight: 600; cursor: pointer; }
    .cart-summary { display: flex; justify-content: space-between; align-items: center; margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #f3f4f6; flex-wrap: wrap; gap: 1rem; }
    .total-price { font-size: 2rem; font-weight: 700; }
    .btn-checkout { padding: 1.25rem 2.5rem; border-radius: 12px; background: linear-gradient(to right, var(--primary), var(--secondary)); color: white; font-size: 1.1rem; font-weight: 700; text-decoration: none; box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.39); }
    .empty-state { text-align: center; padding: 4rem 2rem; }
</style>
@endpush

@section('content')
    <div class="cart-top">
        <a href="{{ route('products.index') }}" class="btn-back">← Continue Shopping</a>
        <h1 class="page-title flex-grow-1 text-center m-0">Your Cart</h1>
        <span style="width: 140px;"></span>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
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
                                    <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}" class="product-img">
                                @else
                                    <div class="product-img d-flex align-items-center justify-content-center text-secondary small">No Img</div>
                                @endif
                                <span class="product-name">{{ $item->product->name }}</span>
                            </div>
                        </td>
                        <td class="text-muted fw-semibold">$<span class="unit-price">{{ number_format($item->unit_price, 2) }}</span></td>
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="qty-controls update-cart-form">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="qty-input" data-id="{{ $item->id }}" data-price="{{ $item->unit_price }}" onchange="updateRow(this)">
                            </form>
                        </td>
                        <td class="fw-bold">$<span class="subtotal" id="subtotal-{{ $item->id }}">{{ number_format($item->subtotal, 2) }}</span></td>
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
                    <span class="text-muted fw-semibold text-uppercase small">Estimated Total</span>
                    <div class="total-price">$<span id="cart-total">{{ number_format($cart->total_amount, 2) }}</span></div>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn-checkout">Proceed to Checkout</a>
            </div>
        @else
            <div class="empty-state">
                <h3 class="text-muted mb-4">Your cart is feeling a little empty.</h3>
                <a href="{{ route('products.index') }}" class="btn-checkout d-inline-block">Browse Products</a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    function updateRow(input) {
        let id = input.getAttribute('data-id');
        let price = parseFloat(input.getAttribute('data-price'));
        let qty = parseInt(input.value) || 1;
        let subtotal = price * qty;
        document.getElementById('subtotal-' + id).innerText = subtotal.toFixed(2);
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(el => { total += parseFloat(el.innerText); });
        document.getElementById('cart-total').innerText = total.toFixed(2);
        let form = input.closest('form');
        let url = form.getAttribute('action');
        let token = form.querySelector('input[name="_token"]').value;
        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
            body: JSON.stringify({ _method: 'PUT', quantity: qty })
        }).then(r => { if (!r.ok) console.error('Failed to update cart'); }).catch(console.error);
    }
</script>
@endpush
