<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orderIds = OrderItem::where('seller_id', Auth::id())
            ->distinct()
            ->pluck('order_id');

        $orders = Order::with('user')
            ->whereIn('id', $orderIds)
            ->latest()
            ->paginate(15);

        return view('seller.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $items = $order->items()
            ->with('product')
            ->where('seller_id', Auth::id())
            ->get();

        abort_if($items->isEmpty(), 403);

        $order->load('user');

        return view('seller.orders.show', compact('order', 'items'));
    }
}
