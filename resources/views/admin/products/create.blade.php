<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Product</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        .btn-primary { background: #EDE9E4; color: #000; padding: .75rem 1.5rem; border-radius: 9999px; text-decoration: none; }
        .btn-primary:hover { background: #d6d1cc; }
    </style>
    </head>
<body class="antialiased text-gray-900 bg-gray-100">

<header class="bg-white shadow mb-6">
    <div class="max-w-4xl mx-auto flex items-center justify-between py-4 px-6">
        <h1 class="text-xl font-bold">Add Product</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn-primary">Back to Dashboard</a>
    </div>
    </header>

<main class="max-w-4xl mx-auto px-4">
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded shadow p-6">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <input type="text" name="name" placeholder="Product Name" class="p-2 border rounded" required>
            <input type="number" step="0.01" name="price" placeholder="Price" class="p-2 border rounded" required>
            <input type="number" name="qty" placeholder="Quantity" class="p-2 border rounded" required>
            <input type="file" name="image" class="p-2 border rounded" required>
            <textarea name="description" placeholder="Description" class="p-2 border rounded md:col-span-2" required></textarea>
            <div class="md:col-span-2 flex items-center gap-2">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded border">Cancel</a>
                <button type="submit" class="btn-primary">Create Product</button>
            </div>
        </form>
    </div>
</main>

</body>
</html>


