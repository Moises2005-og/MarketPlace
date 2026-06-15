<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ApprovalStatus;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'sellers' => User::sellers()->where('status', UserStatus::Approved)->count(),
            'products' => Product::count(),
            'published' => Product::published()->count(),
            'sales' => Order::whereNotIn('status', ['cancelled'])->sum('total'),
            'orders' => Order::count(),
            'pending_products' => Product::where('approval_status', ApprovalStatus::Pending)->count(),
            'pending_sellers' => User::sellers()->where('status', UserStatus::Pending)->count(),
            'low_stock' => Product::where('stock', '<=', 5)->where('stock', '>', 0)->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $pendingProducts = Product::with(['seller', 'category'])
            ->where('approval_status', ApprovalStatus::Pending)
            ->latest()
            ->take(5)
            ->get();
        $pendingSellers = User::sellers()
            ->where('status', UserStatus::Pending)
            ->latest()
            ->take(5)
            ->get();

        $categoryStats = Category::withCount('products')
            ->orderByDesc('products_count')
            ->take(6)
            ->get();

        $topProducts = OrderItem::selectRaw('product_name, SUM(quantity) as total_qty, SUM(subtotal) as total_revenue')
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        $lowStockProducts = Product::with(['seller', 'category'])
            ->where('stock', '<=', 5)
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'pendingProducts',
            'pendingSellers',
            'categoryStats',
            'topProducts',
            'lowStockProducts'
        ));
    }
}
