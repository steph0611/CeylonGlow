<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean'
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
        } else {
            $path = null;
        }

        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'category' => $request->category,
            'image' => $path,
            'is_featured' => $request->has('is_featured')
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service added successfully!');
    }

    public function edit($id)
    {
        $service = Service::find($id);
        if (!$service) {
            return redirect()->route('admin.services.index')->with('error', 'Service not found.');
        }
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::find($id);
        if (!$service) {
            return redirect()->route('admin.services.index')->with('error', 'Service not found.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean'
        ]);

        // Handle image replacement if a new one is uploaded
        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $newPath = $request->file('image')->store('services', 'public');
            $service->image = $newPath;
        }

        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->duration = $request->duration;
        $service->category = $request->category;
        $service->is_featured = $request->has('is_featured');
        $service->save();

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully!');
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        if ($service) {
            // Delete image if exists
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $service->delete();
            return redirect()->back()->with('success', 'Service deleted successfully!');
        }
        return redirect()->back()->with('error', 'Service not found.');
    }
}
