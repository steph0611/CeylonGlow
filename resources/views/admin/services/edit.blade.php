<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceylon Glow - Edit Service</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">

<!-- Header -->
<div class="bg-gradient-to-br from-indigo-500 via-purple-500 to-purple-700 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <div class="relative max-w-6xl mx-auto px-6 py-12">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-white bg-opacity-20 p-4 rounded-2xl backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold mb-2 tracking-tight">Edit Service</h1>
                    <p class="text-blue-100 text-lg">Update your Ceylon Glow service information</p>
                </div>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-white bg-opacity-20 text-white px-8 py-4 rounded-xl hover:bg-opacity-30 transition-all duration-300 backdrop-blur-sm border border-white border-opacity-30 hover:border-opacity-50 font-semibold">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto px-6 py-12">
    @if ($errors->any())
        <div class="mb-8 p-6 rounded-2xl bg-red-50 border-2 border-red-200 text-red-700 shadow-lg">
            <div class="flex items-center mb-3">
                <svg class="w-6 h-6 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <h3 class="font-bold text-lg">Please fix the following errors:</h3>
            </div>
            <ul class="list-disc list-inside space-y-2 ml-6">
                @foreach ($errors->all() as $error)
                    <li class="font-medium">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <form method="POST" action="{{ route('admin.services.update', $service->_id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Current Image -->
            @if($service->image)
                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                    <label class="block text-sm font-semibold text-gray-800 mb-3 tracking-wide">Current Image</label>
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-32 h-32 object-cover rounded-xl border-2 border-gray-200 shadow-sm">
                    </div>
                </div>
            @endif

            <!-- Service Image -->
            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                <label class="block text-sm font-semibold text-gray-800 mb-3 tracking-wide">Update Service Image (Optional)</label>
                <div class="space-y-4">
                    <input type="file" name="image" id="image" accept="image/*" class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-4 focus:ring-green-500/20 focus:border-green-500 transition-all duration-300 bg-white hover:border-gray-300" onchange="previewImage(event)">
                    <div id="imagePreview" class="hidden">
                        <img id="preview" class="w-full h-56 object-cover rounded-xl border-2 border-dashed border-gray-300 shadow-inner" alt="Image preview">
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-3 font-medium">Upload a new image to replace the current one (JPG, PNG, GIF)</p>
            </div>

            <!-- Service Details -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="relative">
                    <label for="name" class="block text-sm font-semibold text-gray-800 mb-3 tracking-wide">Service Name</label>
                    <input type="text" name="name" id="name" class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-4 focus:ring-green-500/20 focus:border-green-500 transition-all duration-300 bg-white hover:border-gray-300" placeholder="Enter service name" required value="{{ old('name', $service->name) }}">
                </div>
                
                <div class="relative">
                    <label for="category" class="block text-sm font-semibold text-gray-800 mb-3 tracking-wide">Category</label>
                    <select name="category" id="category" class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-4 focus:ring-green-500/20 focus:border-green-500 transition-all duration-300 bg-white hover:border-gray-300" required>
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

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="relative">
                    <label for="price" class="block text-sm font-semibold text-gray-800 mb-3 tracking-wide">Price ($)</label>
                    <input type="number" step="0.01" name="price" id="price" class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-4 focus:ring-green-500/20 focus:border-green-500 transition-all duration-300 bg-white hover:border-gray-300" placeholder="0.00" required value="{{ old('price', $service->price) }}">
                </div>
                
                <div class="relative">
                    <label for="duration" class="block text-sm font-semibold text-gray-800 mb-3 tracking-wide">Duration</label>
                    <input type="text" name="duration" id="duration" class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-4 focus:ring-green-500/20 focus:border-green-500 transition-all duration-300 bg-white hover:border-gray-300" placeholder="e.g., 60 minutes" required value="{{ old('duration', $service->duration) }}">
                </div>
            </div>

            <div class="relative">
                <label for="description" class="block text-sm font-semibold text-gray-800 mb-3 tracking-wide">Service Description</label>
                <textarea name="description" id="description" rows="6" class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-4 focus:ring-green-500/20 focus:border-green-500 transition-all duration-300 bg-white hover:border-gray-300" placeholder="Describe your service in detail..." required>{{ old('description', $service->description) }}</textarea>
                <p class="text-sm text-gray-500 mt-3 font-medium">Provide a detailed description of the service, its benefits, and what clients can expect</p>
            </div>

            <!-- Featured Service -->
            <div class="flex items-center p-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border-2 border-gray-200 hover:border-green-500 transition-colors duration-300">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $service->is_featured ?? false) ? 'checked' : '' }} class="w-5 h-5 text-green-600 border-2 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                <label for="is_featured" class="ml-4 text-gray-700">
                    <span class="font-semibold text-lg">Featured Service</span>
                    <p class="text-sm text-gray-600 mt-1">This service will appear prominently on the website and be highlighted to customers</p>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-between pt-6 border-t-2 border-gray-100">
                <div class="text-sm text-gray-500">
                    <p class="font-medium">All fields marked with * are required</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="bg-white text-gray-700 px-8 py-4 rounded-xl hover:bg-gray-50 transition-all duration-300 font-semibold border-2 border-gray-200 hover:border-gray-300 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 text-white px-8 py-4 rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Service
                    </button>
                </div>
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