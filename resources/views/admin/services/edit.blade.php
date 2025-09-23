<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Service - Ceylon Glow Admin</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="antialiased text-gray-900 bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold">Ceylon Glow Admin</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">Dashboard</a>
                        <a href="{{ route('admin.services.index') }}" class="text-[#506c2a] font-medium">Services</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Edit Service</h2>
                    <p class="text-gray-600">Update service information</p>
                </div>

                <div class="bg-white shadow sm:rounded-lg">
                    <form method="POST" action="{{ route('admin.services.update', $service->_id) }}" enctype="multipart/form-data" class="px-6 py-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Service Name</label>
                                <input type="text" name="name" id="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#506c2a] focus:border-[#506c2a] sm:text-sm" value="{{ old('name', $service->name) }}">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#506c2a] focus:border-[#506c2a] sm:text-sm">{{ old('description', $service->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700">Price ($)</label>
                                    <input type="number" name="price" id="price" step="0.01" min="0" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#506c2a] focus:border-[#506c2a] sm:text-sm" value="{{ old('price', $service->price) }}">
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="duration" class="block text-sm font-medium text-gray-700">Duration</label>
                                    <input type="text" name="duration" id="duration" placeholder="e.g., 60 minutes" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#506c2a] focus:border-[#506c2a] sm:text-sm" value="{{ old('duration', $service->duration) }}">
                                    @error('duration')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category" id="category" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#506c2a] focus:border-[#506c2a] sm:text-sm">
                                    <option value="">Select a category</option>
                                    <option value="Facial" {{ old('category', $service->category) == 'Facial' ? 'selected' : '' }}>Facial</option>
                                    <option value="Body Treatment" {{ old('category', $service->category) == 'Body Treatment' ? 'selected' : '' }}>Body Treatment</option>
                                    <option value="Massage" {{ old('category', $service->category) == 'Massage' ? 'selected' : '' }}>Massage</option>
                                    <option value="Hair Care" {{ old('category', $service->category) == 'Hair Care' ? 'selected' : '' }}>Hair Care</option>
                                    <option value="Nail Care" {{ old('category', $service->category) == 'Nail Care' ? 'selected' : '' }}>Nail Care</option>
                                    <option value="Specialty" {{ old('category', $service->category) == 'Specialty' ? 'selected' : '' }}>Specialty</option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">Service Image</label>
                                @if($service->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="h-20 w-20 object-cover rounded-lg">
                                        <p class="text-sm text-gray-500 mt-1">Current image</p>
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#506c2a] file:text-white hover:file:bg-[#3e541f]">
                                <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image</p>
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $service->is_featured) ? 'checked' : '' }} class="h-4 w-4 text-[#506c2a] focus:ring-[#506c2a] border-gray-300 rounded">
                                <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                    Featured Service (will appear prominently on the website)
                                </label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.services.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#506c2a]">
                                Cancel
                            </a>
                            <button type="submit" class="bg-[#506c2a] py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-[#3e541f] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#506c2a]">
                                Update Service
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
