<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CartComponent extends Component
{
    public array $cart = [];
    public array $selected = [];
    public float $total = 0.0;

    public function mount(): void
    {
        $this->cart = Session::get('cart', []);
        $this->selected = Session::get('cart_selected', []);
        $this->recalculateTotal();
    }

    public function remove(string $key): void
    {
        if (!isset($this->cart[$key])) {
            return;
        }
        $quantity = (int) ($this->cart[$key]['quantity'] ?? 0);

        // Restock product
        $product = Product::find($key);
        if ($product) {
            $currentQty = (int) ($product->qty ?? $product->stock ?? 0);
            $product->qty = $currentQty + $quantity;
            if (isset($product->stock)) {
                $product->stock = $product->qty;
            }
            $product->save();
        }

        unset($this->cart[$key]);
        Session::put('cart', $this->cart);
        $this->recalculateTotal();
        session()->flash('success', 'Item removed from cart.');
    }

    private function recalculateTotal(): void
    {
        $total = 0.0;
        foreach ($this->cart as $key => $item) {
            if (in_array($key, $this->selected, true)) {
                $total += (float) ($item['price'] ?? 0) * (int) ($item['quantity'] ?? 0);
            }
        }
        $this->total = $total;
    }

    public function toggleSelect(string $key): void
    {
        if (in_array($key, $this->selected, true)) {
            $this->selected = array_values(array_filter($this->selected, fn ($k) => $k !== $key));
        } else {
            $this->selected[] = $key;
        }
        Session::put('cart_selected', $this->selected);
        $this->recalculateTotal();
    }

    public function selectAll(): void
    {
        $this->selected = array_keys($this->cart);
        Session::put('cart_selected', $this->selected);
        $this->recalculateTotal();
    }

    public function clearSelection(): void
    {
        $this->selected = [];
        Session::forget('cart_selected');
        $this->recalculateTotal();
    }

    public function render()
    {
        return view('livewire.cart-component');
    }
}


