<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.dashboard', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public'); // storage/app/public/products
        } else {
            $path = null;
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'qty' => $request->qty,
            'description' => $request->description,
            'image' => $path,
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('admin.dashboard')->with('error', 'Product not found.');
        }
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('admin.dashboard')->with('error', 'Product not found.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image replacement if a new one is uploaded
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $newPath = $request->file('image')->store('products', 'public');
            $product->image = $newPath;
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->qty = $request->qty;
        $product->description = $request->description;
        $product->save();

        return redirect()->route('admin.dashboard')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            // Delete image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
            return redirect()->back()->with('success', 'Product deleted successfully!');
        }
        return redirect()->back()->with('error', 'Product not found.');
    }
}
