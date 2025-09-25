<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of the customer's orders
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Get all orders and filter by customer ID
        $allOrders = Order::orderBy('placed_at', 'desc')->get();
        $userOrders = $allOrders->filter(function ($order) use ($user) {
            return isset($order->customer['id']) && $order->customer['id'] == $user->id;
        });
        
        // Convert to paginated collection
        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $offset = ($currentPage - 1) * $perPage;
        
        $orders = new \Illuminate\Pagination\LengthAwarePaginator(
            $userOrders->slice($offset, $perPage)->values(),
            $userOrders->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );
        
        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display the specified order
     */
    public function show(string $id): View
    {
        $user = Auth::user();
        
        // Get order and verify it belongs to the current user
        $order = Order::findOrFail($id);
        
        // Check if the order belongs to the current user
        if (!isset($order->customer['id']) || $order->customer['id'] != $user->id) {
            abort(403, 'Unauthorized access to this order.');
        }
        
        return view('customer.orders.show', compact('order'));
    }
}
