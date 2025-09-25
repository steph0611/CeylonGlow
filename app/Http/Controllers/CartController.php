<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\Order;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $request->session()->get('cart', []);
        $selectedKeys = $request->session()->get('cart_selected', []);
        $total = 0;
        foreach ($cart as $key => $item) {
            if (!empty($selectedKeys) && !in_array($key, $selectedKeys, true)) {
                continue;
            }
            $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
        }

        return view('cart.index', [
            'cart' => $cart,
            'selected' => $selectedKeys,
            'total' => $total,
        ]);
    }

    public function add(Request $request, string $productId): RedirectResponse
    {
        $quantityToAdd = (int) $request->input('quantity', 1);
        if ($quantityToAdd < 1) {
            $quantityToAdd = 1;
        }

        try {
            $product = DB::transaction(function () use ($productId, $quantityToAdd) {
                /** @var Product|null $product */
                $product = Product::lockForUpdate()->find($productId);
                if (!$product) {
                    return null;
                }

                $currentQty = (int) ($product->qty ?? $product->stock ?? 0);
                if ($currentQty < $quantityToAdd) {
                    return false; // signal not enough stock
                }

                $product->qty = $currentQty - $quantityToAdd;
                // If using SQL schema stock column, keep in sync
                if (isset($product->stock)) {
                    $product->stock = $product->qty;
                }
                $product->save();

                return $product;
            });

            if ($product === null) {
                return back()->with('error', 'Product not found.');
            }
            if ($product === false) {
                return back()->with('error', 'Not enough stock available.');
            }

            $cart = $request->session()->get('cart', []);
            $key = (string) $productId;
            if (!isset($cart[$key])) {
                $cart[$key] = [
                    'id' => $productId,
                    'name' => $product->name,
                    'price' => (float) $product->price,
                    'quantity' => 0,
                    'image' => !empty($product->image) ? asset('storage/' . $product->image) : asset('images/service-1.jpg'),
                ];
            }
            $cart[$key]['quantity'] += $quantityToAdd;

            $request->session()->put('cart', $cart);

            return back()->with('success', 'Added to cart.');
        } catch (\Throwable $e) {
            Log::error('Failed to add to cart', ['error' => $e->getMessage()]);
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function remove(Request $request, string $productId): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $key = (string) $productId;
        if (!isset($cart[$key])) {
            return back();
        }

        $quantity = (int) ($cart[$key]['quantity'] ?? 0);

        DB::transaction(function () use ($productId, $quantity) {
            /** @var Product|null $product */
            $product = Product::lockForUpdate()->find($productId);
            if ($product) {
                $currentQty = (int) ($product->qty ?? $product->stock ?? 0);
                $product->qty = $currentQty + $quantity;
                if (isset($product->stock)) {
                    $product->stock = $product->qty;
                }
                $product->save();
            }
        });

        unset($cart[$key]);
        $request->session()->put('cart', $cart);

        $selected = $request->session()->get('cart_selected', []);
        $request->session()->put('cart_selected', array_values(array_filter($selected, fn ($k) => $k !== $key)));

        return back()->with('success', 'Item removed from cart.');
    }

    public function toggleSelect(Request $request, string $productId): RedirectResponse
    {
        $key = (string) $productId;
        $selected = $request->session()->get('cart_selected', []);
        if (in_array($key, $selected, true)) {
            $selected = array_values(array_filter($selected, fn ($k) => $k !== $key));
        } else {
            $selected[] = $key;
        }
        $request->session()->put('cart_selected', $selected);
        return back();
    }

    public function selectAll(Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $request->session()->put('cart_selected', array_keys($cart));
        return back();
    }

    public function clearSelection(Request $request): RedirectResponse
    {
        $request->session()->forget('cart_selected');
        return back();
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $selectedKeys = $request->session()->get('cart_selected', []);
        
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        // If no items are selected, select all items
        if (empty($selectedKeys)) {
            $selectedKeys = array_keys($cart);
        }

        $total = 0.0;
        $items = [];
        $orderedItems = []; // Track which items were ordered for cart cleanup
        
        foreach ($cart as $key => $item) {
            if (!in_array($key, $selectedKeys, true)) {
                continue; // Skip unselected items
            }
            
            $qty = (int) ($item['quantity'] ?? 0);
            $lineTotal = (float) ($item['price'] ?? 0) * $qty;
            $total += $lineTotal;
            $items[] = [
                'product_id' => (int) $key,
                'name' => (string) ($item['name'] ?? ''),
                'price' => (float) ($item['price'] ?? 0),
                'quantity' => $qty,
                'line_total' => $lineTotal,
            ];
            $orderedItems[] = $key;
        }

        if (empty($items)) {
            return back()->with('error', 'No items selected for ordering.');
        }

        try {
            $user = $request->user();
            if (!$user) {
                return back()->with('error', 'You must be logged in to place an order.');
            }
            
            $customer = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];

            Order::create([
                'customer' => $customer,
                'items' => $items,
                'total' => $total,
                'status' => 'pending',
                'placed_at' => now()->toDateTimeString(),
            ]);

            // Remove only ordered items from cart
            $remainingCart = $cart;
            foreach ($orderedItems as $key) {
                unset($remainingCart[$key]);
            }
            $request->session()->put('cart', $remainingCart);
            
            // Update selected items to remove ordered ones
            $remainingSelected = array_values(array_filter($selectedKeys, fn($k) => !in_array($k, $orderedItems)));
            if (empty($remainingSelected)) {
                $request->session()->forget('cart_selected');
            } else {
                $request->session()->put('cart_selected', $remainingSelected);
            }

            return back()->with('success', 'Order placed successfully.');
        } catch (\Throwable $e) {
            \Log::error('Place order failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to place order.');
        }
    }

    
}


