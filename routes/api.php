<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

// API Authentication endpoints
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        
        // Create API token
        $token = $user->createToken('api-token')->plainTextToken;
        
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
            ],
            'token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Invalid credentials'
    ], 401);
});

Route::post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    
    return response()->json([
        'success' => true,
        'message' => 'Logged out successfully'
    ]);
})->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user();
});

// Products API
Route::get('/products', function () {
    $products = Product::query()
        ->select(['id', 'name', 'price', 'qty', 'image', 'created_at'])
        ->orderByDesc('created_at')
        ->get()
        ->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => (float) $p->price,
                'qty' => (int) ($p->qty ?? $p->stock ?? 0),
                'image_url' => !empty($p->image) ? asset('storage/' . $p->image) : asset('images/service-1.jpg'),
                'created_at' => $p->created_at,
            ];
        });

    return response()->json(['data' => $products]);
});

Route::get('/products/{product}', function (Product $product) {
    return response()->json([
        'data' => [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description ?? null,
            'price' => (float) $product->price,
            'qty' => (int) ($product->qty ?? $product->stock ?? 0),
            'image_url' => !empty($product->image) ? asset('storage/' . $product->image) : asset('images/service-1.jpg'),
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ],
    ]);
});

// Cart API (session-based) - protected by authentication
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/cart', function (Request $request) {
    $cart = $request->session()->get('cart', []);
    $selectedKeys = $request->session()->get('cart_selected', []);
    $total = 0;
    foreach ($cart as $key => $item) {
        if (!empty($selectedKeys) && !in_array($key, $selectedKeys, true)) {
            continue;
        }
        $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
    }

    return response()->json([
        'data' => [
            'items' => array_values($cart),
            'selected' => $selectedKeys,
            'total' => (float) $total,
        ],
    ]);
});
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/cart/add/{product}', function (Request $request, string $productId) {
    $quantityToAdd = (int) $request->input('quantity', 1);
    if ($quantityToAdd < 1) {
        $quantityToAdd = 1;
    }

    $product = DB::transaction(function () use ($productId, $quantityToAdd) {
        /** @var Product|null $product */
        $product = Product::lockForUpdate()->find($productId);
        if (!$product) {
            return null;
        }

        $currentQty = (int) ($product->qty ?? $product->stock ?? 0);
        if ($currentQty < $quantityToAdd) {
            return false; // not enough stock
        }

        $product->qty = $currentQty - $quantityToAdd;
        if (isset($product->stock)) {
            $product->stock = $product->qty;
        }
        $product->save();

        return $product;
    });

    if ($product === null) {
        return response()->json(['message' => 'Product not found.'], 404);
    }
    if ($product === false) {
        return response()->json(['message' => 'Not enough stock available.'], 422);
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

    return response()->json(['message' => 'Added to cart.', 'data' => array_values($cart)]);
});

Route::delete('/cart/remove/{product}', function (Request $request, string $productId) {
    $cart = $request->session()->get('cart', []);
    $key = (string) $productId;
    if (!isset($cart[$key])) {
        return response()->json(['message' => 'Item not in cart.'], 404);
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

    return response()->json(['message' => 'Item removed from cart.', 'data' => array_values($cart)]);
});

Route::post('/cart/select/{product}', function (Request $request, string $productId) {
    $key = (string) $productId;
    $selected = $request->session()->get('cart_selected', []);
    if (in_array($key, $selected, true)) {
        $selected = array_values(array_filter($selected, fn ($k) => $k !== $key));
    } else {
        $selected[] = $key;
    }
    $request->session()->put('cart_selected', $selected);
    return response()->json(['data' => $selected]);
});

Route::post('/cart/select-all', function (Request $request) {
    $cart = $request->session()->get('cart', []);
    $request->session()->put('cart_selected', array_keys($cart));
    return response()->json(['data' => array_keys($cart)]);
});

Route::post('/cart/clear-selection', function (Request $request) {
    $request->session()->forget('cart_selected');
    return response()->json(['data' => []]);
});
});

 

