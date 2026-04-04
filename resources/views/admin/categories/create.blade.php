<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #ec4899;
            --primary-hover: #db2777;
            --secondary: #6366f1;
            --bg-gradient: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            --card-bg: rgba(255, 255, 255, 0.9);
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --input-border: #d1d5db;
            --input-focus: #f472b6;
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
            max-width: 800px;
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
            align-items: center;
            margin-bottom: 2rem;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 1rem;
        }

        .header h2 {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-outline {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            padding: 0.5rem 1.25rem;
            border-radius: 999px;
            border: 2px solid #e5e7eb;
            transition: var(--transition);
        }

        .btn-outline:hover {
            color: var(--text-main);
            border-color: var(--text-muted);
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
            padding-left: 2rem;
        }
        
        .alert-error ul { margin-top: 0.5rem; }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-main);
        }

        input[type="text"],
        input[type="number"],
        input[type="url"],
        textarea,
        select {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid var(--input-border);
            font-size: 1rem;
            color: var(--text-main);
            background: #f9fafb;
            transition: var(--transition);
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: var(--input-focus);
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
            background: #ffffff;
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 12px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 14px 0 rgba(236, 72, 153, 0.39);
            margin-top: 1rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.4);
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="header">
            <h2>Add New Category</h2>
            <a href="{{ route('dashboard') }}" class="btn-outline">Back to Dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Whoops! Something went wrong.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="form-row">
                <div class="form-group">
                    <label>Category Name</label> 
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Electronics" required>
                </div>
                
                <div class="form-group">
                    <label>Sort Order</label> 
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Image URL (Optional)</label> 
                <input type="url" name="image" value="{{ old('image') }}" placeholder="https://example.com/logo.jpg">
            </div>
            
            <div class="form-group">
                <label>Description (Optional)</label> 
                <textarea name="description" placeholder="A brief overview of the category...">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn-submit">Publish Category</button>
        </form>
    </div>

</body>
</html>
