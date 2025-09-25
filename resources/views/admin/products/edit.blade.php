<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceylon Glow - Edit Product</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .btn-primary {
            @apply bg-[#506c2a] text-white px-6 py-3 rounded-xl hover:bg-[#3d5220] transition-colors font-medium;
        }
        .btn-secondary {
            @apply bg-gray-200 text-gray-800 px-6 py-3 rounded-xl hover:bg-gray-300 transition-colors font-medium;
        }
        .form-input {
            @apply w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a] transition-colors;
        }
        .form-label {
            @apply block text-sm font-medium text-gray-700 mb-2;
        }
        .image-preview {
            @apply w-full h-48 object-cover rounded-xl border-2 border-dashed border-gray-300;
        }
    </style>
</head>
<body class="antialiased bg-gray-50">

<!-- Header -->
<div class="gradient-bg text-white">
    <div class="max-w-6xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Edit Product</h1>
                <p class="text-blue-100">Update your Ceylon Glow product information</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-white bg-opacity-20 text-white px-6 py-3 rounded-xl hover:bg-opacity-30 transition-colors">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-6 py-8">
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg bg-red-100 border border-red-200 text-red-700">
            <h3 class="font-semibold mb-2">Please fix the following errors:</h3>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg p-8">
        <form action="{{ route('admin.products.update', $product->_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Current Image -->
            @if($product->image)
                <div>
                    <label class="form-label">Current Image</label>
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-lg border">
                    </div>
                </div>
            @endif

            <!-- Product Image -->
            <div>
                <label class="form-label">Update Product Image (Optional)</label>
                <div class="space-y-4">
                    <input type="file" name="image" id="image" accept="image/*" class="form-input" onchange="previewImage(event)">
                    <div id="imagePreview" class="hidden">
                        <img id="preview" class="image-preview" alt="Image preview">
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-1">Upload a new image to replace the current one (JPG, PNG, GIF)</p>
            </div>

            <!-- Product Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" name="name" id="name" class="form-input" placeholder="Enter product name" required value="{{ old('name', $product->name) }}">
                </div>
                
                <div>
                    <label for="price" class="form-label">Price ($)</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-input" placeholder="0.00" required value="{{ old('price', $product->price) }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="qty" class="form-label">Quantity in Stock</label>
                    <input type="number" name="qty" id="qty" class="form-input" placeholder="0" required value="{{ old('qty', $product->qty) }}">
                </div>
                
                <div>
                    <label for="category" class="form-label">Category (Optional)</label>
                    <select name="category" id="category" class="form-input">
                        <option value="">Select a category</option>
                        <option value="skincare" {{ old('category', $product->category ?? '') == 'skincare' ? 'selected' : '' }}>Skincare</option>
                        <option value="makeup" {{ old('category', $product->category ?? '') == 'makeup' ? 'selected' : '' }}>Makeup</option>
                        <option value="haircare" {{ old('category', $product->category ?? '') == 'haircare' ? 'selected' : '' }}>Hair Care</option>
                        <option value="bodycare" {{ old('category', $product->category ?? '') == 'bodycare' ? 'selected' : '' }}>Body Care</option>
                        <option value="accessories" {{ old('category', $product->category ?? '') == 'accessories' ? 'selected' : '' }}>Accessories</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="description" class="form-label">Product Description</label>
                <textarea name="description" id="description" rows="4" class="form-input" placeholder="Describe your product in detail..." required>{{ old('description', $product->description) }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Provide a detailed description of the product, its benefits, and ingredients</p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}
</script>

</body>
</html>