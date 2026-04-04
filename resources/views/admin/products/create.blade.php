<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Product</title>
</head>
<body>
    <h2>Add New Product</h2>
    <a href="/dashboard">Back to Dashboard</a><br><br>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf
        <div><label>Name:</label> <input type="text" name="name" value="{{ old('name') }}" required></div><br>
        <div><label>Description:</label> <textarea name="description">{{ old('description') }}</textarea></div><br>
        <div><label>Price:</label> <input type="number" step="0.01" name="price" value="{{ old('price') }}" required></div><br>
        <div><label>Stock:</label> <input type="number" name="stock" value="{{ old('stock') }}" required></div><br>
        <div><label>Category ID:</label> <input type="number" name="category_id" value="{{ old('category_id') }}" required></div><br>
        <div><label>Image URL:</label> <input type="url" name="image_url" value="{{ old('image_url') }}"></div><br>
        <button type="submit">Create Product</button>
    </form>
</body>
</html>
