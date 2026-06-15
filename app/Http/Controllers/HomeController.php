<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::active()->withCount('products')->orderBy('name')->get();
        $featuredProducts = Product::with(['category', 'seller'])
            ->published()
            ->featured()
            ->latest()
            ->take(8)
            ->get();
        $recentProducts = Product::with(['category', 'seller'])
            ->published()
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('categories', 'featuredProducts', 'recentProducts'));
    }
}
