<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
            --input-border: #d1d5db;
            --input-focus: #818cf8;
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
            min-height: 120px;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: var(--input-focus);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            background: #ffffff;
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 12px;
            background: linear-gradient(to right, #10b981, #059669);
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.39);
            margin-top: 1rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        
        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="header">
            <h2>Edit Product</h2>
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

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Product Name</label> 
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Price ($)</label> 
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required>
                </div>
                
                <div class="form-group">
                    <label>Stock Quantity</label> 
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Category</label> 
                    <select name="category_id" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @if(old('category_id', $product->category_id) == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label> 
                    <select name="is_active">
                        <option value="1" @if($product->is_active) selected @endif>Active</option>
                        <option value="0" @if(!$product->is_active) selected @endif>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Product Image</label> 
                <input type="file" name="image" accept="image/*">
                @if($product->image_url)
                    <div style="margin-top: 10px;">
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="Current Image" style="max-height: 100px; border-radius: 8px;">
                    </div>
                @endif
            </div>
            
            <div class="form-group">
                <label>Description (Optional)</label> 
                <textarea name="description">{{ old('description', $product->description) }}</textarea>
            </div>

            <button type="submit" class="btn-submit">Save Changes</button>
        </form>
    </div>

</body>
</html>
