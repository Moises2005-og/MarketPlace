<?php

namespace App\Http\Controllers\Seller;

use App\Enums\ApprovalStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index(): View
    {
        $products = Product::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('seller.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::active()->orderBy('name')->get();

        return view('seller.products.create', compact('categories'));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['approval_status'] = ApprovalStatus::Pending;
        $data['is_featured'] = false;

        $this->productService->create(
            $data,
            $request->file('main_image'),
            $request->file('gallery', [])
        );

        return redirect()->route('seller.products.index')
            ->with('success', 'Produto enviado para aprovação. Será publicado após revisão do administrador.');
    }

    public function edit(Product $product): View
    {
        abort_unless($product->user_id === Auth::id(), 403);

        $categories = Category::active()->orderBy('name')->get();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product->user_id === Auth::id(), 403);

        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        unset($data['is_featured']);

        $needsReapproval = $product->approval_status === ApprovalStatus::Approved;

        if ($needsReapproval) {
            $data['approval_status'] = ApprovalStatus::Pending;
        }

        $this->productService->update(
            $product,
            $data,
            $request->file('main_image'),
            $request->file('gallery', [])
        );

        $message = $needsReapproval
            ? 'Produto atualizado e reenviado para aprovação.'
            : 'Produto atualizado com sucesso.';

        return redirect()->route('seller.products.index')->with('success', $message);
    }

    public function destroy(Product $product): RedirectResponse
    {
        abort_unless($product->user_id === Auth::id(), 403);

        $this->productService->delete($product);

        return back()->with('success', 'Produto eliminado com sucesso.');
    }
}
