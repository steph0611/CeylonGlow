<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceylon Glow - Add New Service</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .btn-primary {
            @apply bg-gradient-to-r from-[#506c2a] to-[#3d5220] text-white px-8 py-4 rounded-xl hover:from-[#3d5220] hover:to-[#2a3a16] transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5;
        }
        .btn-secondary {
            @apply bg-white text-gray-700 px-8 py-4 rounded-xl hover:bg-gray-50 transition-all duration-300 font-semibold border-2 border-gray-200 hover:border-gray-300 shadow-md hover:shadow-lg;
        }
        .form-input {
            @apply w-full px-5 py-4 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-4 focus:ring-[#506c2a]/20 focus:border-[#506c2a] transition-all duration-300 bg-white hover:border-gray-300;
        }
        .form-label {
            @apply block text-sm font-semibold text-gray-800 mb-3 tracking-wide;
        }
        .image-preview {
            @apply w-full h-56 object-cover rounded-xl border-2 border-dashed border-gray-300 shadow-inner;
        }
        .form-section {
            @apply bg-white rounded-2xl shadow-xl border border-gray-100 p-8 mb-8;
        }
        .section-title {
            @apply text-xl font-bold text-gray-800 mb-6 pb-3 border-b-2 border-gray-100 flex items-center;
        }
        .floating-label {
            @apply absolute -top-2 left-4 bg-white px-2 text-xs font-semibold text-[#506c2a] uppercase tracking-wider;
        }
        .input-group {
            @apply relative;
        }
        .error-message {
            @apply text-red-600 text-sm mt-2 font-medium;
        }
        .success-message {
            @apply text-green-600 text-sm mt-2 font-medium;
        }
    </style>
</head>
<body class="antialiased bg-gray-50">

<!-- Header -->
<div class="gradient-bg text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    <div class="relative max-w-6xl mx-auto px-6 py-12">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-white bg-opacity-20 p-4 rounded-2xl backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold mb-2 tracking-tight">Add New Service</h1>
                    <p class="text-blue-100 text-lg">Create a new spa service for your Ceylon Glow collection</p>
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

    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <!-- Service Image Section -->
        <div class="form-section">
            <h2 class="section-title">
                <svg class="w-6 h-6 mr-3 text-[#506c2a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Service Image
            </h2>
            <div class="input-group">
                <label class="form-label">Upload Service Image</label>
                <div class="space-y-6">
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-[#506c2a] transition-colors duration-300">
                        <input type="file" name="image" id="image" accept="image/*" class="hidden" required onchange="previewImage(event)">
                        <label for="image" class="cursor-pointer">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-lg font-semibold text-gray-700 mb-2">Click to upload image</p>
                            <p class="text-sm text-gray-500">JPG, PNG, GIF up to 10MB</p>
                        </label>
                    </div>
                    <div id="imagePreview" class="hidden">
                        <img id="preview" class="image-preview" alt="Image preview">
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Details Section -->
        <div class="form-section">
            <h2 class="section-title">
                <svg class="w-6 h-6 mr-3 text-[#506c2a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Service Information
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="input-group">
                    <label for="name" class="form-label">Service Name</label>
                    <input type="text" name="name" id="name" class="form-input" placeholder="Enter service name" required value="{{ old('name') }}">
                </div>
                
                <div class="input-group">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-input" required>
                        <option value="">Select a category</option>
                        <option value="Facial" {{ old('category') == 'Facial' ? 'selected' : '' }}>Facial</option>
                        <option value="Body Treatment" {{ old('category') == 'Body Treatment' ? 'selected' : '' }}>Body Treatment</option>
                        <option value="Massage" {{ old('category') == 'Massage' ? 'selected' : '' }}>Massage</option>
                        <option value="Hair Care" {{ old('category') == 'Hair Care' ? 'selected' : '' }}>Hair Care</option>
                        <option value="Nail Care" {{ old('category') == 'Nail Care' ? 'selected' : '' }}>Nail Care</option>
                        <option value="Specialty" {{ old('category') == 'Specialty' ? 'selected' : '' }}>Specialty</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="input-group">
                    <label for="price" class="form-label">Price ($)</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-input" placeholder="0.00" required value="{{ old('price') }}">
                </div>
                
                <div class="input-group">
                    <label for="duration" class="form-label">Duration</label>
                    <input type="text" name="duration" id="duration" class="form-input" placeholder="e.g., 60 minutes" required value="{{ old('duration') }}">
                </div>
            </div>

            <div class="input-group">
                <label for="description" class="form-label">Service Description</label>
                <textarea name="description" id="description" rows="6" class="form-input" placeholder="Describe your service in detail, including benefits, what clients can expect, and any special requirements..." required>{{ old('description') }}</textarea>
                <p class="text-sm text-gray-500 mt-3 font-medium">Provide a comprehensive description to help clients understand your service better</p>
            </div>
        </div>

        <!-- Service Options Section -->
        <div class="form-section">
            <h2 class="section-title">
                <svg class="w-6 h-6 mr-3 text-[#506c2a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Service Options
            </h2>
            
            <div class="flex items-center p-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border-2 border-gray-200 hover:border-[#506c2a] transition-colors duration-300">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-5 h-5 text-[#506c2a] border-2 border-gray-300 rounded focus:ring-[#506c2a] focus:ring-2">
                <label for="is_featured" class="ml-4 text-gray-700">
                    <span class="font-semibold text-lg">Featured Service</span>
                    <p class="text-sm text-gray-600 mt-1">This service will appear prominently on the website and be highlighted to customers</p>
                </label>
            </div>
        </div>

        <!-- Submit Section -->
        <div class="form-section">
            <div class="flex items-center justify-between pt-6 border-t-2 border-gray-100">
                <div class="text-sm text-gray-500">
                    <p class="font-medium">All fields marked with * are required</p>
                </div>
                <div class="flex items-center space-x-4">
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
                        Create Service
                    </button>
                </div>
            </div>
        </div>
    </form>
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