<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(string $slug): View
    {
        $product = Product::with(['category', 'seller', 'images'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $product->incrementViews();

        $relatedProducts = Product::with('category')
            ->published()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
