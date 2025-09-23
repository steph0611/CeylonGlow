<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::take(8)->get();
        $services = Service::where('is_featured', true)->take(5)->get();
        
        return view('dashboard', compact('products', 'services'));
    }
}
