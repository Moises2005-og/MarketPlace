<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(): Cart
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }

        $sessionId = Session::getId();

        return Cart::firstOrCreate(
            ['session_id' => $sessionId, 'user_id' => null],
            ['session_id' => $sessionId]
        );
    }

    public function addItem(Product $product, int $quantity = 1): CartItem
    {
        $cart = $this->getCart();
        $quantity = max(1, min($quantity, $product->stock));

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $newQty = min($item->quantity + $quantity, $product->stock);
            $item->update(['quantity' => $newQty, 'price' => $product->price]);

            return $item->fresh();
        }

        return $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->price,
        ]);
    }

    public function updateQuantity(CartItem $item, int $quantity): ?CartItem
    {
        if ($quantity <= 0) {
            $item->delete();

            return null;
        }

        $maxStock = $item->product->stock;
        $item->update(['quantity' => min($quantity, $maxStock)]);

        return $item->fresh();
    }

    public function removeItem(CartItem $item): void
    {
        $item->delete();
    }

    public function clear(Cart $cart): void
    {
        $cart->items()->delete();
    }

    public function mergeGuestCart(int $userId): void
    {
        $sessionId = Session::getId();
        $guestCart = Cart::where('session_id', $sessionId)->whereNull('user_id')->first();

        if (! $guestCart) {
            return;
        }

        $userCart = Cart::firstOrCreate(['user_id' => $userId]);

        foreach ($guestCart->items as $guestItem) {
            $existing = $userCart->items()->where('product_id', $guestItem->product_id)->first();

            if ($existing) {
                $existing->update([
                    'quantity' => $existing->quantity + $guestItem->quantity,
                    'price' => $guestItem->product->price ?? $guestItem->price,
                ]);
            } else {
                $userCart->items()->create([
                    'product_id' => $guestItem->product_id,
                    'quantity' => $guestItem->quantity,
                    'price' => $guestItem->price,
                ]);
            }
        }

        $guestCart->items()->delete();
        $guestCart->delete();
    }

    public function getItemCount(): int
    {
        return $this->getCart()->load('items')->item_count;
    }
}
