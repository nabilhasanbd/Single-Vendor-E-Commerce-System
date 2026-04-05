@extends('layouts.app')

@section('title', 'Checkout — ' . config('app.name'))

@push('styles')
<style>
    :root {
        --primary: #6366f1;
        --secondary: #ec4899;
        --card-bg: rgba(255, 255, 255, 0.95);
        --text-main: #1f2937;
        --text-muted: #6b7280;
        --border-radius: 20px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .checkout-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
    .btn-back { display: inline-flex; text-decoration: none; color: var(--text-muted); font-weight: 600; background: var(--card-bg); padding: 0.75rem 1.5rem; border-radius: 999px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .btn-back:hover { color: var(--primary); }
    .page-title { font-size: 2rem; font-weight: 700; margin: 0; background: linear-gradient(to right, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .checkout-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; }
    .checkout-card { background: var(--card-bg); border-radius: var(--border-radius); box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.4); padding: 2.5rem; }
    .section-title { font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; border-bottom: 2px solid #f3f4f6; padding-bottom: 0.5rem; }
    .form-group { margin-bottom: 1.5rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    label { display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-main); }
    input[type="text"] { width: 100%; padding: 0.85rem 1rem; border-radius: 8px; border: 1px solid #d1d5db; font-size: 1rem; background: #f9fafb; outline: none; }
    input[type="text"]:focus { border-color: #818cf8; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2); background: #fff; }
    .payment-options { display: flex; flex-direction: column; gap: 1rem; }
    .payment-method { display: flex; align-items: center; padding: 1rem; border: 1px solid #d1d5db; border-radius: 8px; cursor: pointer; }
    .payment-method:hover { border-color: var(--primary); background: #f8fafc; }
    .payment-method input { appearance: none; width: 20px; height: 20px; border: 2px solid var(--text-muted); border-radius: 50%; margin-right: 1rem; }
    .payment-method input:checked { border-color: var(--primary); background: var(--primary); }
    .disabled { opacity: 0.6; cursor: not-allowed; }
    .summary-item { display: flex; justify-content: space-between; margin-bottom: 1rem; font-weight: 500; }
    .summary-breakdown { margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px dashed var(--text-muted); }
    .summary-total { display: flex; justify-content: space-between; font-size: 1.5rem; font-weight: 700; color: var(--primary); margin-bottom: 2rem; }
    .btn-submit { display: block; width: 100%; padding: 1.25rem; border: none; border-radius: 12px; background: linear-gradient(to right, var(--primary), var(--secondary)); color: white; font-size: 1.15rem; font-weight: 700; cursor: pointer; box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.39); }
    @media (max-width: 900px) { .checkout-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
    <div class="checkout-top">
        <a href="{{ route('cart.index') }}" class="btn-back">← Back to Cart</a>
        <h1 class="page-title flex-grow-1 text-center m-0">Secure Checkout</h1>
        <span style="min-width: 120px;"></span>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="checkout-grid">
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
                            <div class="small text-muted">Pay securely when the package arrives.</div>
                        </div>
                    </label>
                    <label class="payment-method disabled">
                        <input type="radio" name="payment_method" value="sslcommerz">
                        <div>
                            <strong>SSLCommerz (Online Payment)</strong>
                            <div class="small" style="color: var(--secondary);">Routing configured. Secure redirect enabled.</div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="checkout-card">
                <h2 class="section-title">Order Summary</h2>
                <div class="summary-breakdown">
                    @foreach($cart->items as $item)
                    <div class="summary-item small">
                        <span>{{ $item->quantity }}× {{ $item->product->name }}</span>
                        <span>${{ number_format($item->subtotal, 2) }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="summary-item text-muted">
                    <span>Subtotal</span>
                    <span>${{ number_format($cart->total_amount, 2) }}</span>
                </div>
                <div class="summary-item text-muted">
                    <span>Shipping</span>
                    <span>$0.00</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>${{ number_format($cart->total_amount, 2) }}</span>
                </div>
                <button type="submit" class="btn-submit">Confirm Order</button>
                <p class="small text-muted text-center mt-3 mb-0">By confirming, your cart will be cleared and product stock will update.</p>
            </div>
        </div>
    </form>
@endsection
