<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Membership;
use App\Models\MembershipPurchase;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function buyNow(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity');

        try {
            $product = DB::transaction(function () use ($productId, $quantity) {
                $product = Product::lockForUpdate()->find($productId);
                if (!$product) {
                    return null;
                }

                $currentQty = (int) ($product->qty ?? 0);
                if ($currentQty < $quantity) {
                    return false; // signal not enough stock
                }

                return $product;
            });

            if ($product === null) {
                return back()->with('error', 'Product not found.');
            }
            if ($product === false) {
                return back()->with('error', 'Not enough stock available.');
            }

            // Store the buy now data in session
            $request->session()->put('checkout_data', [
                'type' => 'single_product',
                'product_id' => $productId,
                'quantity' => $quantity,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => (float) $product->price,
                    'image' => !empty($product->image) ? asset('storage/' . $product->image) : asset('images/service-1.jpg'),
                ]
            ]);

            return redirect()->route('checkout.index');
        } catch (\Throwable $e) {
            Log::error('Buy now failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function cartCheckout(Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $selectedKeys = $request->session()->get('cart_selected', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // If no items are selected, select all items
        if (empty($selectedKeys)) {
            $selectedKeys = array_keys($cart);
        }

        $items = [];
        $total = 0.0;
        
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
                'image' => $item['image'] ?? asset('images/service-1.jpg'),
            ];
        }

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'No items selected for checkout.');
        }

        // Store the cart checkout data in session
        $request->session()->put('checkout_data', [
            'type' => 'cart',
            'items' => $items,
            'total' => $total,
            'selected_keys' => $selectedKeys,
        ]);

        return redirect()->route('checkout.index');
    }

    public function index(Request $request): View
    {
        $checkoutData = $request->session()->get('checkout_data');
        
        if (!$checkoutData) {
            return redirect()->route('products.index')->with('error', 'No items to checkout.');
        }

        if ($checkoutData['type'] === 'single_product') {
            $product = $checkoutData['product'];
            $quantity = $checkoutData['quantity'];
            $subtotal = $product['price'] * $quantity;
            $tax = $subtotal * 0.1; // 10% tax
            $total = $subtotal + $tax;
            
            return view('checkout.index', [
                'type' => 'single_product',
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'items' => null,
                'membership' => null
            ]);
        } elseif ($checkoutData['type'] === 'membership' || $checkoutData['type'] === 'membership_renewal') {
            // Membership checkout
            $membership = $checkoutData['membership'];
            $subtotal = $membership['price'];
            $tax = $subtotal * 0.1; // 10% tax
            $total = $subtotal + $tax;
            
            return view('checkout.index', [
                'type' => $checkoutData['type'],
                'membership' => $membership,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'product' => null,
                'quantity' => null,
                'items' => null
            ]);
        } else {
            // Cart checkout
            $items = $checkoutData['items'];
            $subtotal = $checkoutData['total'];
            $tax = $subtotal * 0.1; // 10% tax
            $total = $subtotal + $tax;
            
            return view('checkout.index', [
                'type' => 'cart',
                'items' => $items,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'product' => null,
                'quantity' => null,
                'membership' => null
            ]);
        }
    }

    public function processPayment(Request $request): RedirectResponse
    {
        $request->validate([
            'payment_method' => 'required|in:card,cash_on_delivery',
            'card_number' => 'required_if:payment_method,card|string|min:16|max:19',
            'expiry_date' => 'required_if:payment_method,card|string',
            'cvv' => 'required_if:payment_method,card|string|min:3|max:4',
            'cardholder_name' => 'required_if:payment_method,card|string|max:255',
            'billing_address' => 'required|string|max:500',
            'shipping_address' => 'required|string|max:500',
        ]);

        $checkoutData = $request->session()->get('checkout_data');
        
        if (!$checkoutData) {
            return redirect()->route('products.index')->with('error', 'No items to checkout.');
        }

        try {
            $user = $request->user();
            if (!$user) {
                return back()->with('error', 'You must be logged in to complete the purchase.');
            }

            // Process payment based on method
            if ($request->input('payment_method') === 'card') {
                // Simulate card payment processing
                $paymentResult = $this->processCardPayment($request);
                if (!$paymentResult['success']) {
                    return back()->with('error', $paymentResult['message']);
                }
            }

            if ($checkoutData['type'] === 'single_product') {
                // Single product checkout
                $product = $checkoutData['product'];
                $quantity = $checkoutData['quantity'];
                $subtotal = $product['price'] * $quantity;
                $tax = $subtotal * 0.1;
                $total = $subtotal + $tax;

                // Update product stock
                DB::transaction(function () use ($checkoutData) {
                    $product = Product::lockForUpdate()->find($checkoutData['product_id']);
                    if ($product) {
                        $currentQty = (int) ($product->qty ?? 0);
                        $product->qty = $currentQty - $checkoutData['quantity'];
                        $product->save();
                    }
                });

                // Create order
                $order = Order::create([
                    'customer' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ],
                    'items' => [
                        [
                            'product_id' => $product['id'],
                            'name' => $product['name'],
                            'price' => $product['price'],
                            'quantity' => $quantity,
                            'line_total' => $subtotal,
                        ]
                    ],
                    'total' => $total,
                    'status' => $request->input('payment_method') === 'card' ? 'paid' : 'pending',
                    'payment_method' => $request->input('payment_method'),
                    'billing_address' => $request->input('billing_address'),
                    'shipping_address' => $request->input('shipping_address'),
                    'placed_at' => now()->toDateTimeString(),
                    'order_type' => 'product',
                ]);

            } elseif ($checkoutData['type'] === 'membership') {
                // Membership checkout
                $membership = $checkoutData['membership'];
                $subtotal = $membership['price'];
                $tax = $subtotal * 0.1;
                $total = $subtotal + $tax;

                // Create order
                $order = Order::create([
                    'customer' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ],
                    'items' => [
                        [
                            'membership_id' => $membership['id'],
                            'name' => $membership['name'],
                            'description' => $membership['description'],
                            'price' => $membership['price'],
                            'duration_days' => $membership['duration_days'],
                            'benefits' => $membership['benefits'],
                            'quantity' => 1,
                            'line_total' => $subtotal,
                        ]
                    ],
                    'total' => $total,
                    'status' => $request->input('payment_method') === 'card' ? 'paid' : 'pending',
                    'payment_method' => $request->input('payment_method'),
                    'billing_address' => $request->input('billing_address'),
                    'shipping_address' => $request->input('shipping_address'),
                    'placed_at' => now()->toDateTimeString(),
                    'order_type' => 'membership',
                    'membership_id' => $membership['id'],
                ]);

                // Create membership purchase
                if ($request->input('payment_method') === 'card') {
                    $startDate = now();
                    $expiryDate = $startDate->copy()->addDays($membership['duration_days']);

                    MembershipPurchase::create([
                        'user_id' => $user->id,
                        'membership_id' => $membership['id'],
                        'status' => 'active',
                        'purchased_at' => $startDate,
                        'expires_at' => $expiryDate,
                        'payment_method' => $request->input('payment_method'),
                        'amount_paid' => $total,
                        'order_id' => $order->_id,
                    ]);
                }

            } else {
                // Cart checkout
                $items = $checkoutData['items'];
                $subtotal = $checkoutData['total'];
                $tax = $subtotal * 0.1;
                $total = $subtotal + $tax;

                // Update product stock for all items
                DB::transaction(function () use ($items) {
                    foreach ($items as $item) {
                        $product = Product::lockForUpdate()->find($item['product_id']);
                        if ($product) {
                            $currentQty = (int) ($product->qty ?? 0);
                            $product->qty = $currentQty - $item['quantity'];
                            $product->save();
                        }
                    }
                });

                // Create order
                $order = Order::create([
                    'customer' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ],
                    'items' => $items,
                    'total' => $total,
                    'status' => $request->input('payment_method') === 'card' ? 'paid' : 'pending',
                    'payment_method' => $request->input('payment_method'),
                    'billing_address' => $request->input('billing_address'),
                    'shipping_address' => $request->input('shipping_address'),
                    'placed_at' => now()->toDateTimeString(),
                    'order_type' => 'product',
                ]);

                // Remove ordered items from cart
                $cart = $request->session()->get('cart', []);
                $selectedKeys = $checkoutData['selected_keys'];
                $remainingCart = $cart;
                foreach ($selectedKeys as $key) {
                    unset($remainingCart[$key]);
                }
                $request->session()->put('cart', $remainingCart);
                
                // Update selected items
                $remainingSelected = array_values(array_filter($request->session()->get('cart_selected', []), fn($k) => !in_array($k, $selectedKeys)));
                if (empty($remainingSelected)) {
                    $request->session()->forget('cart_selected');
                } else {
                    $request->session()->put('cart_selected', $remainingSelected);
                }
            }

            // Clear checkout session
            $request->session()->forget('checkout_data');

            // Redirect based on order type
            if ($checkoutData['type'] === 'membership') {
                return redirect()->route('checkout.success', $order->id)
                    ->with('success', 'Membership purchased successfully! Welcome to Ceylon Glow!');
            } else {
                return redirect()->route('checkout.success', $order->id)
                    ->with('success', 'Order placed successfully!');
            }

        } catch (\Throwable $e) {
            Log::error('Payment processing failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Payment processing failed. Please try again.');
        }
    }

    public function success(Request $request, $orderId): View
    {
        $order = Order::findOrFail($orderId);
        
        // Verify the order belongs to the current user
        if ($order->customer['id'] !== $request->user()->id) {
            abort(403, 'Unauthorized access to order.');
        }

        return view('checkout.success', compact('order'));
    }

    private function processCardPayment(Request $request): array
    {
        // Simulate card payment processing
        // In a real application, you would integrate with a payment gateway like Stripe, PayPal, etc.
        
        $cardNumber = $request->input('card_number');
        $expiryDate = $request->input('expiry_date');
        $cvv = $request->input('cvv');
        $cardholderName = $request->input('cardholder_name');

        // Basic validation
        if (strlen($cardNumber) < 16) {
            return ['success' => false, 'message' => 'Invalid card number.'];
        }

        if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiryDate)) {
            return ['success' => false, 'message' => 'Invalid expiry date format. Use MM/YY.'];
        }

        if (strlen($cvv) < 3) {
            return ['success' => false, 'message' => 'Invalid CVV.'];
        }

        // Simulate payment processing delay
        sleep(1);

        // Simulate random payment failures (5% chance)
        if (rand(1, 100) <= 5) {
            return ['success' => false, 'message' => 'Payment declined. Please try a different card.'];
        }

        return ['success' => true, 'message' => 'Payment successful.'];
    }
}
