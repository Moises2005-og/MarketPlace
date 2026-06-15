<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SellerController extends Controller
{
    public function index(): View
    {
        $sellers = User::sellers()
            ->with('role')
            ->withCount('products')
            ->latest()
            ->paginate(15);

        return view('admin.sellers.index', compact('sellers'));
    }

    public function show(User $seller): View
    {
        abort_unless($seller->isSeller(), 404);

        $sales = OrderItem::with(['order.user', 'product'])
            ->where('seller_id', $seller->id)
            ->latest()
            ->paginate(20);

        $stats = [
            'products' => $seller->products()->count(),
            'total_sales' => OrderItem::where('seller_id', $seller->id)->sum('subtotal'),
            'orders' => OrderItem::where('seller_id', $seller->id)->distinct('order_id')->count('order_id'),
        ];

        return view('admin.sellers.show', compact('seller', 'sales', 'stats'));
    }

    public function approve(User $seller): RedirectResponse
    {
        abort_unless($seller->isSeller(), 404);

        $seller->update(['status' => UserStatus::Approved]);

        return back()->with('success', 'Vendedor aprovado com sucesso.');
    }

    public function reject(User $seller): RedirectResponse
    {
        abort_unless($seller->isSeller(), 404);

        $seller->update(['status' => UserStatus::Rejected]);

        return back()->with('success', 'Vendedor reprovado.');
    }

    public function suspend(User $seller): RedirectResponse
    {
        abort_unless($seller->isSeller(), 404);

        $seller->update(['status' => UserStatus::Suspended]);

        return back()->with('success', 'Conta do vendedor suspensa.');
    }

    public function reactivate(User $seller): RedirectResponse
    {
        abort_unless($seller->isSeller(), 404);

        $seller->update(['status' => UserStatus::Approved]);

        return back()->with('success', 'Conta do vendedor reativada.');
    }
}
