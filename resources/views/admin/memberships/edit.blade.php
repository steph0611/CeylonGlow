<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Membership Plan - Admin</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        .status-badge {
            @apply inline-flex items-center px-3 py-1 rounded-full text-sm font-medium;
        }
        .status-active { @apply bg-green-100 text-green-800; }
        .status-inactive { @apply bg-red-100 text-red-800; }

        .btn-primary { @apply bg-[#506c2a] text-white px-4 py-2 rounded-lg hover:bg-[#3d5220] transition-colors; }
        .btn-secondary { @apply bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors; }
        .btn-danger { @apply bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors; }
    </style>
</head>
<body class="antialiased text-gray-900 bg-gray-50">

<div class="max-w-4xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Membership Plan</h1>
            <p class="text-gray-600 mt-1">{{ $membership->name }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.memberships.index') }}" class="btn-secondary">
                Back to Memberships
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-100 border border-green-200 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 rounded-lg bg-red-100 border border-red-200 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <!-- Edit Form -->
    <div class="bg-white rounded-xl shadow p-6">
        <form method="POST" action="{{ route('admin.memberships.update', $membership->_id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Plan Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Plan Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $membership->name) }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a]" required>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a]" required>{{ old('description', $membership->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price & Duration -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $membership->price) }}" 
                           step="0.01" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a]" required>
                    @error('price')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duration_days" class="block text-sm font-medium text-gray-700 mb-1">Duration (Days)</label>
                    <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days', $membership->duration_days) }}" 
                           min="1"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a]" required>
                    @error('duration_days')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Sort Order -->
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $membership->sort_order) }}" 
                       min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a]">
                @error('sort_order')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Checkbox -->
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $membership->is_active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-[#506c2a] focus:ring-[#506c2a]">
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
            </div>

            <!-- Benefits -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Benefits</label>
                <div id="benefits-container" class="space-y-2">
                    @if($membership->benefits && count($membership->benefits) > 0)
                        @foreach($membership->benefits as $index => $benefit)
                            <div class="flex items-center space-x-2">
                                <input type="text" name="benefits[]" value="{{ old('benefits.' . $index, $benefit) }}" 
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a]" 
                                       placeholder="Enter a benefit">
                                <button type="button" onclick="removeBenefit(this)" class="text-red-600 hover:text-red-800">✕</button>
                            </div>
                        @endforeach
                    @else
                        <div class="flex items-center space-x-2">
                            <input type="text" name="benefits[]" value="{{ old('benefits.0') }}" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a]" 
                                   placeholder="Enter a benefit">
                            <button type="button" onclick="removeBenefit(this)" class="text-red-600 hover:text-red-800">✕</button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addBenefit()" class="mt-2 text-sm text-[#506c2a] hover:text-[#3d5220]">+ Add Benefit</button>
                @error('benefits')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center space-x-3 pt-4">
                <button type="submit" class="btn-primary">Update Membership Plan</button>
                <a href="{{ route('admin.memberships.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    function addBenefit() {
        const container = document.getElementById('benefits-container');
        const div = document.createElement('div');
        div.className = 'flex items-center space-x-2';
        div.innerHTML = `
            <input type="text" name="benefits[]" 
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a]" 
                   placeholder="Enter a benefit">
            <button type="button" onclick="removeBenefit(this)" class="text-red-600 hover:text-red-800">✕</button>
        `;
        container.appendChild(div);
    }

    function removeBenefit(button) {
        button.parentElement.remove();
    }
</script>

</body>
</html>
