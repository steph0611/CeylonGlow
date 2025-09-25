<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceylon Glow - Edit Service</title>
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
                <h1 class="text-3xl font-bold mb-2">Edit Service</h1>
                <p class="text-blue-100">Update your Ceylon Glow service information</p>
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
        <form method="POST" action="{{ route('admin.services.update', $service->_id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Current Image -->
            @if($service->image)
                <div>
                    <label class="form-label">Current Image</label>
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-32 h-32 object-cover rounded-lg border">
                    </div>
                </div>
            @endif

            <!-- Service Image -->
            <div>
                <label class="form-label">Update Service Image (Optional)</label>
                <div class="space-y-4">
                    <input type="file" name="image" id="image" accept="image/*" class="form-input" onchange="previewImage(event)">
                    <div id="imagePreview" class="hidden">
                        <img id="preview" class="image-preview" alt="Image preview">
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-1">Upload a new image to replace the current one (JPG, PNG, GIF)</p>
            </div>

            <!-- Service Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="form-label">Service Name</label>
                    <input type="text" name="name" id="name" class="form-input" placeholder="Enter service name" required value="{{ old('name', $service->name) }}">
                </div>
                
                <div>
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-input" required>
                        <option value="">Select a category</option>
                        <option value="Facial" {{ old('category', $service->category ?? '') == 'Facial' ? 'selected' : '' }}>Facial</option>
                        <option value="Body Treatment" {{ old('category', $service->category ?? '') == 'Body Treatment' ? 'selected' : '' }}>Body Treatment</option>
                        <option value="Massage" {{ old('category', $service->category ?? '') == 'Massage' ? 'selected' : '' }}>Massage</option>
                        <option value="Hair Care" {{ old('category', $service->category ?? '') == 'Hair Care' ? 'selected' : '' }}>Hair Care</option>
                        <option value="Nail Care" {{ old('category', $service->category ?? '') == 'Nail Care' ? 'selected' : '' }}>Nail Care</option>
                        <option value="Specialty" {{ old('category', $service->category ?? '') == 'Specialty' ? 'selected' : '' }}>Specialty</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="form-label">Price ($)</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-input" placeholder="0.00" required value="{{ old('price', $service->price) }}">
                </div>
                
                <div>
                    <label for="duration" class="form-label">Duration</label>
                    <input type="text" name="duration" id="duration" class="form-input" placeholder="e.g., 60 minutes" required value="{{ old('duration', $service->duration) }}">
                </div>
            </div>

            <div>
                <label for="description" class="form-label">Service Description</label>
                <textarea name="description" id="description" rows="4" class="form-input" placeholder="Describe your service in detail..." required>{{ old('description', $service->description) }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Provide a detailed description of the service, its benefits, and what clients can expect</p>
            </div>

            <!-- Featured Service -->
            <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $service->is_featured ?? false) ? 'checked' : '' }} class="w-4 h-4 text-[#506c2a] border-gray-300 rounded focus:ring-[#506c2a]">
                <label for="is_featured" class="ml-3 text-sm text-gray-700">
                    <span class="font-medium">Featured Service</span> - This service will appear prominently on the website
                </label>
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
                    Update Service
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