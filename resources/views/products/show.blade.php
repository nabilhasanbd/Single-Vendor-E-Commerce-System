<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
</head>
<body>
    <h2>{{ $product->name }}</h2>
    <a href="{{ route('products.index') }}">Back to Products</a><br><br>

    <div>
        @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="Image" width="200">
        @endif
        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
        <p><strong>Stock:</strong> {{ $product->stock }}</p>
        <p><strong>Category ID:</strong> {{ $product->category_id }}</p>
        <p><strong>Description:</strong> {{ $product->description ?? 'No description available.' }}</p>
    </div>
</body>
</html>
