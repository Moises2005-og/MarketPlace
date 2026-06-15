<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected OrderService $orderService
    ) {}

    public function index(): View|RedirectResponse
    {
        $cart = $this->cartService->getCart()->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'O carrinho está vazio.');
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        try {
            $order = $this->orderService->createFromCart($request->user(), $request->validated());

            return redirect()
                ->route('orders.show', $order)
                ->with('success', 'Pedido realizado com sucesso!');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
