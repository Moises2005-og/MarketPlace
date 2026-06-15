<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function index(): View
    {
        $cart = $this->cartService->getCart()->load('items.product');

        return view('cart.index', compact('cart'));
    }

    public function store(CartItemRequest $request): RedirectResponse
    {
        $product = Product::published()->findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stock insuficiente para este produto.');
        }

        $this->cartService->addItem($product, $request->quantity);

        return back()->with('success', 'Produto adicionado ao carrinho.');
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $request->validate(['quantity' => 'required|integer|min:0']);
        $this->cartService->updateQuantity($cartItem, $request->quantity);

        return back()->with('success', 'Carrinho atualizado.');
    }

    public function destroy(CartItem $cartItem): RedirectResponse
    {
        $this->cartService->removeItem($cartItem);

        return back()->with('success', 'Produto removido do carrinho.');
    }
}
