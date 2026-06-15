<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index(Request $request): View
    {
        $categories = Category::active()->orderBy('name')->get();
        $products = $this->productService
            ->search($request->only(['q', 'category_id', 'category_slug', 'min_price', 'max_price', 'sort']))
            ->paginate(12)
            ->withQueryString();

        return view('search.index', compact('products', 'categories'));
    }
}
