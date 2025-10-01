<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
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
            $request->session()->put('buy_now', [
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

    public function index(Request $request): View
    {
        $buyNowData = $request->session()->get('buy_now');
        
        if (!$buyNowData) {
            return redirect()->route('products.index')->with('error', 'No items to checkout.');
        }

        $product = $buyNowData['product'];
        $quantity = $buyNowData['quantity'];
        $subtotal = $product['price'] * $quantity;
        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $tax;

        return view('checkout.index', compact('product', 'quantity', 'subtotal', 'tax', 'total'));
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

        $buyNowData = $request->session()->get('buy_now');
        
        if (!$buyNowData) {
            return redirect()->route('products.index')->with('error', 'No items to checkout.');
        }

        try {
            $user = $request->user();
            if (!$user) {
                return back()->with('error', 'You must be logged in to complete the purchase.');
            }

            $product = $buyNowData['product'];
            $quantity = $buyNowData['quantity'];
            $subtotal = $product['price'] * $quantity;
            $tax = $subtotal * 0.1;
            $total = $subtotal + $tax;

            // Process payment based on method
            if ($request->input('payment_method') === 'card') {
                // Simulate card payment processing
                $paymentResult = $this->processCardPayment($request);
                if (!$paymentResult['success']) {
                    return back()->with('error', $paymentResult['message']);
                }
            }

            // Update product stock
            DB::transaction(function () use ($buyNowData) {
                $product = Product::lockForUpdate()->find($buyNowData['product_id']);
                if ($product) {
                    $currentQty = (int) ($product->qty ?? 0);
                    $product->qty = $currentQty - $buyNowData['quantity'];
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
            ]);

            // Clear buy now session
            $request->session()->forget('buy_now');

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Order placed successfully!');

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
