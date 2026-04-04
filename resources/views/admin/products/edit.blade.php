<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product ({{ $product->name }})</h2>
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

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div><label>Name:</label> <input type="text" name="name" value="{{ old('name', $product->name) }}" required></div><br>
        <div><label>Description:</label> <textarea name="description">{{ old('description', $product->description) }}</textarea></div><br>
        <div><label>Price:</label> <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required></div><br>
        <div><label>Stock:</label> <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required></div><br>
        <div><label>Category ID:</label> <input type="number" name="category_id" value="{{ old('category_id', $product->category_id) }}" required></div><br>
        <div><label>Image URL:</label> <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}"></div><br>
        <div>
            <label>Status:</label> 
            <select name="is_active">
                <option value="1" @if($product->is_active) selected @endif>Active</option>
                <option value="0" @if(!$product->is_active) selected @endif>Inactive</option>
            </select>
        </div><br>
        <button type="submit">Update Product</button>
    </form>
</body>
</html>
