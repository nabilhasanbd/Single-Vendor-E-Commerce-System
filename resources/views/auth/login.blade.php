@extends('layouts.app')

@section('title', 'Login — ' . config('app.name'))

@push('styles')
<style>
    .auth-card { background: rgba(255, 255, 255, 0.95); padding: 3rem; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); max-width: 450px; margin: 2rem auto; }
    .auth-card h2 { text-align: center; margin-bottom: 2rem; color: #6366f1; font-size: 2rem; }
    .form-group { margin-bottom: 1.5rem; }
    label { display: block; font-weight: 600; margin-bottom: 0.5rem; color: #1f2937; }
    input[type="email"], input[type="password"] { width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #d1d5db; outline: none; }
    input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2); }
    .btn-submit { width: 100%; padding: 1rem; background: #6366f1; color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 1.1rem; cursor: pointer; }
    .btn-submit:hover { background: #4f46e5; }
    .auth-links { text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: #6b7280; }
    .auth-links a { color: #6366f1; text-decoration: none; font-weight: 600; }
    .alert-err { background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; }
</style>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="auth-card">
                <h2>Welcome to {{ config('app.name') }}</h2>

                @if ($errors->any())
                    <div class="alert-err">
                        @foreach ($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>
                    <button type="submit" class="btn-submit">Sign In</button>
                </form>

                <div class="auth-links">
                    <p>Don't have an account? <a href="{{ route('register') }}">Create one now</a></p>
                    <p class="mt-2"><a href="{{ route('products.index') }}">← Return to shop</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
