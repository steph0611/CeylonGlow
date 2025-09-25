<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Service;
use App\Models\Order;
use App\Models\Booking;

class AdminBannerController extends Controller
{
   
    public function index()
    {
        $products = Product::all();
        $services = Service::all();
        $banners  = Banner::orderBy('position')->get();
        $orders = Order::orderBy('placed_at', 'desc')->take(5)->get();
        $bookings = Booking::orderBy('created_at', 'desc')->take(5)->get();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        
        // Stock status calculations
        $lowStockThreshold = 10; // Define low stock threshold
        $lowStockProducts = Product::where('qty', '>', 0)->where('qty', '<=', $lowStockThreshold)->get();
        $outOfStockProducts = Product::where('qty', '<=', 0)->get();
        $totalLowStock = $lowStockProducts->count();
        $totalOutOfStock = $outOfStockProducts->count();
        
        return view('admin.dashboard', compact(
            'products', 
            'services', 
            'banners', 
            'orders', 
            'bookings',
            'totalOrders', 
            'pendingOrders',
            'totalBookings',
            'pendingBookings',
            'lowStockProducts',
            'outOfStockProducts',
            'totalLowStock',
            'totalOutOfStock',
            'lowStockThreshold'
        ));
    }

    
    public function store(Request $request)
    {
        // Validate images
        $request->validate([
            'banner1' => 'nullable|image|max:5120', 
            'banner2' => 'nullable|image|max:5120',
            'banner3' => 'nullable|image|max:5120',
            'banner4' => 'nullable|image|max:5120',
        ]);

        for ($i = 1; $i <= 4; $i++) {
            if ($request->hasFile('banner' . $i)) {
                $file = $request->file('banner' . $i);

                // Convert image to Base64
                $imageData = base64_encode(file_get_contents($file->getRealPath()));
                $mimeType = $file->getMimeType(); 

                $base64 = "data:$mimeType;base64,$imageData";

                // Update or create banner
                $banner = Banner::where('position', $i)->first();
                if ($banner) {
                    $banner->update(['image' => $base64]);
                } else {
                    Banner::create([
                        'position' => $i,
                        'image' => $base64
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Banners updated successfully!');
    }

    
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->back()->with('success', 'Banner deleted successfully!');
    }
}
