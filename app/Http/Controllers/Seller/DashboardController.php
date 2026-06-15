<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $sellerId = Auth::id();

        $stats = [
            'products' => Product::where('user_id', $sellerId)->count(),
            'active_products' => Product::where('user_id', $sellerId)->published()->count(),
            'total_views' => Product::where('user_id', $sellerId)->sum('view_count'),
            'total_sales' => OrderItem::where('seller_id', $sellerId)->sum('subtotal'),
            'orders' => OrderItem::where('seller_id', $sellerId)->distinct('order_id')->count('order_id'),
            'pending_products' => Product::where('user_id', $sellerId)->pendingApproval()->count(),
            'low_stock' => Product::where('user_id', $sellerId)->where('stock', '<=', 5)->count(),
        ];

        $recentProducts = Product::with('category')
            ->where('user_id', $sellerId)
            ->latest()
            ->take(6)
            ->get();

        $recentSales = OrderItem::with('order.user', 'product')
            ->where('seller_id', $sellerId)
            ->latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('user_id', $sellerId)
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->take(5)
            ->get();

        $topViewed = Product::where('user_id', $sellerId)
            ->orderByDesc('view_count')
            ->take(5)
            ->get();

        return view('seller.dashboard', compact(
            'stats',
            'recentProducts',
            'recentSales',
            'lowStockProducts',
            'topViewed'
        ));
    }
}
