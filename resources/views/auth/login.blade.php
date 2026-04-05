<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Commerce</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-gradient: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            --card-bg: rgba(255, 255, 255, 0.95);
            --text-main: #1f2937;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background: var(--bg-gradient); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { background: var(--card-bg); padding: 3rem; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
        .auth-card h2 { text-align: center; margin-bottom: 2rem; color: var(--primary); font-size: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-main); }
        input[type="email"], input[type="password"] { width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #d1d5db; outline: none; }
        input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2); }
        .btn-submit { width: 100%; padding: 1rem; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 1.1rem; cursor: pointer; transition: 0.3s; }
        .btn-submit:hover { background: var(--primary-hover); transform: translateY(-2px); }
        .auth-links { text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: #6b7280; }
        .auth-links a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .alert { background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; }
        .alert p { margin: 0;}
    </style>
</head>
<body>
    <div class="auth-card">
        <h2>Welcome Back</h2>
        
        @if ($errors->any())
            <div class="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="alert" style="background:#d1fae5; color:#065f46;">
                {{ session('success') }}
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
            <p style="margin-top:0.5rem;"><a href="/">← Return to Shop</a></p>
        </div>
    </div>
</body>
</html>
