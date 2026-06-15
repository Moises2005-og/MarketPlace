<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function createFromCart(User $user, array $data): Order
    {
        return DB::transaction(function () use ($user, $data) {
            $cart = $this->cartService->getCart()->load('items.product');

            if ($cart->items->isEmpty()) {
                throw new \RuntimeException('O carrinho está vazio.');
            }

            foreach ($cart->items as $item) {
                if (! $item->product || ! $item->product->is_active) {
                    throw new \RuntimeException("O produto \"{$item->product?->name}\" não está disponível.");
                }

                if ($item->quantity > $item->product->stock) {
                    throw new \RuntimeException("Stock insuficiente para \"{$item->product->name}\".");
                }
            }

            $subtotal = $cart->subtotal;

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $this->generateOrderNumber(),
                'status' => OrderStatus::Pending,
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'shipping_address' => $data['shipping_address'],
                'phone' => $data['phone'] ?? $user->phone,
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                $product = $item->product;

                $order->items()->create([
                    'product_id' => $product->id,
                    'seller_id' => $product->user_id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);

                $product->decrement('stock', $item->quantity);
            }

            $this->cartService->clear($cart);

            return $order->load('items');
        });
    }

    public function cancel(Order $order): Order
    {
        if (! $order->canCancel()) {
            throw new \RuntimeException('Este pedido não pode ser cancelado.');
        }

        return DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            $order->update([
                'status' => OrderStatus::Cancelled,
                'cancelled_at' => now(),
            ]);

            return $order->fresh();
        });
    }

    public function updateStatus(Order $order, OrderStatus $status): Order
    {
        $order->update(['status' => $status]);

        return $order->fresh();
    }

    protected function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-'.strtoupper(Str::random(10));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
