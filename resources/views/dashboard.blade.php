<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Dashboard</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --secondary: #ec4899;
            --bg-gradient: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            --card-bg: rgba(255, 255, 255, 0.9);
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border-radius: 16px;
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
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 900px;
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 3rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 3rem;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 2rem;
        }

        .header-text h2 {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-main);
        }

        .header-text h2 span {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .role-badge {
            display: inline-block;
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
            padding: 0.25rem 1rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid rgba(99, 102, 241, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            font-weight: 500;
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .quick-actions h3 {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            color: var(--text-muted);
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .action-card {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background: linear-gradient(to top right, #ffffff, #f9fafb);
            border-radius: 12px;
            text-decoration: none;
            color: var(--text-main);
            font-weight: 600;
            font-size: 1.1rem;
            border: 1px solid #e5e7eb;
            transition: var(--transition);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Specific card colorings */
        .card-product { border-bottom: 4px solid var(--primary); }
        .card-product:hover { background: rgba(99, 102, 241, 0.05); border-color: var(--primary); }

        .card-category { border-bottom: 4px solid var(--secondary); }
        .card-category:hover { background: rgba(236, 72, 153, 0.05); border-color: var(--secondary); }
        
        .card-view { border-bottom: 4px solid #10b981; }
        .card-view:hover { background: rgba(16, 185, 129, 0.05); border-color: #10b981; }

        .btn-logout {
            background: transparent;
            color: #ef4444;
            border: 1px solid #fca5a5;
            padding: 0.5rem 1.25rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-logout:hover {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #ef4444;
        }
    </style>
</head>
<body>

    <div class="container">
        
        <!-- Header -->
        <div class="header">
            <div class="header-text">
                <h2>Welcome Back, <span>{{ Auth::user()->name }}</span>!</h2>
                <div class="role-badge">{{ Auth::user()->role }} Account</div>
            </div>
            
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="btn-logout">Sign Out</button>
            </form>
        </div>

        @if (session('success'))
            <div class="alert" style="margin-top: -1.5rem;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Quick Actions Panel -->
        <div class="quick-actions">
            @if(Auth::user()->role === 'admin')
                <h3>Admin Quick Actions</h3>
                <div class="actions-grid">
                    <a href="{{ route('admin.products.create') }}" class="action-card card-product">
                        Add New Product
                    </a>
                    
                    <a href="{{ route('admin.categories.create') }}" class="action-card card-category">
                        Add New Category
                    </a>
                </div>
            @else
                <h3>Customer Actions</h3>
                <div class="actions-grid">
                    <a href="{{ route('products.index') }}" class="action-card card-view">
                        Explore Shop
                    </a>
                    <a href="#" class="action-card card-product">
                        My Orders
                    </a>
                </div>
            @endif
        </div>

    </div>

</body>
</html>
