<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SalesController extends Controller
{
    public function index(): View
    {
        $sellerId = Auth::id();

        $sales = OrderItem::with(['order.user', 'product'])
            ->where('seller_id', $sellerId)
            ->latest()
            ->paginate(20);

        $stats = [
            'total_sales' => OrderItem::where('seller_id', $sellerId)->sum('subtotal'),
            'total_items' => OrderItem::where('seller_id', $sellerId)->sum('quantity'),
            'orders' => OrderItem::where('seller_id', $sellerId)->distinct('order_id')->count('order_id'),
        ];

        return view('seller.sales.index', compact('sales', 'stats'));
    }
}
