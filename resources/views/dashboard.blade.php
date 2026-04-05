@extends('layouts.app')

@section('title', 'Dashboard — ' . config('app.name'))

@push('styles')
<style>
    :root {
        --primary: #6366f1;
        --primary-hover: #4f46e5;
        --secondary: #ec4899;
        --card-bg: rgba(255, 255, 255, 0.9);
        --text-main: #1f2937;
        --text-muted: #6b7280;
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .dash-wrap { max-width: 900px; margin: 0 auto; background: var(--card-bg); border-radius: var(--border-radius); padding: 3rem; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.5); }
    .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 3rem; border-bottom: 2px solid #f3f4f6; padding-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
    .header-text h2 { font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-main); }
    .header-text h2 span { background: linear-gradient(to right, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .role-badge { display: inline-block; background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 0.25rem 1rem; border-radius: 999px; font-size: 0.875rem; font-weight: 600; border: 1px solid rgba(99, 102, 241, 0.2); text-transform: uppercase; letter-spacing: 0.05em; }
    .header-actions { display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
    .quick-actions h3 { font-size: 1.25rem; margin-bottom: 1.5rem; color: var(--text-muted); }
    .actions-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem; }
    .action-card { display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 2rem; background: linear-gradient(to top right, #ffffff, #f9fafb); border-radius: 12px; text-decoration: none; color: var(--text-main); font-weight: 600; font-size: 1.1rem; border: 1px solid #e5e7eb; transition: var(--transition); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); text-align: center; }
    .action-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    .card-product { border-bottom: 4px solid var(--primary); }
    .card-product:hover { background: rgba(99, 102, 241, 0.05); border-color: var(--primary); }
    .card-category { border-bottom: 4px solid var(--secondary); }
    .card-category:hover { background: rgba(236, 72, 153, 0.05); border-color: var(--secondary); }
    .card-view { border-bottom: 4px solid #10b981; }
    .card-view:hover { background: rgba(16, 185, 129, 0.05); border-color: #10b981; }
</style>
@endpush

@section('content')
    <div class="dash-wrap">
        <div class="header">
            <div class="header-text">
                <h2>Welcome Back, <span>{{ Auth::user()->name }}</span>!</h2>
                <div class="role-badge">{{ Auth::user()->role }} Account</div>
            </div>
            <div class="header-actions">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ url('/admin/orders') }}" class="btn btn-primary">View All Orders</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger rounded-pill">Sign Out</button>
                </form>
            </div>
        </div>

        <div class="quick-actions">
            @if(Auth::user()->role === 'admin')
                <h3>Admin Quick Actions</h3>
                <div class="actions-grid">
                    <a href="{{ route('admin.products.create') }}" class="action-card card-product">Add New Product</a>
                    <a href="{{ route('admin.categories.create') }}" class="action-card card-category">Add New Category</a>
                    <a href="{{ route('admin.orders.index') }}" class="action-card card-view">Manage Orders</a>
                </div>
            @else
                <h3>Customer Actions</h3>
                <div class="actions-grid">
                    <a href="{{ route('products.index') }}" class="action-card card-view">Browse Products</a>
                    <a href="{{ route('orders.index') }}" class="action-card card-product">My Orders</a>
                </div>
            @endif
        </div>
    </div>
@endsection
