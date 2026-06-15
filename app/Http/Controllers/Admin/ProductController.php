<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ApprovalStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index(Request $request): View
    {
        $products = Product::with(['category', 'seller'])
            ->when($request->status === 'pending', fn ($q) => $q->pendingApproval())
            ->when($request->status === 'approved', fn ($q) => $q->approved())
            ->when($request->status === 'rejected', fn ($q) => $q->where('approval_status', ApprovalStatus::Rejected))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::active()->orderBy('name')->get();
        $sellers = User::whereHas('role', fn ($q) => $q->where('slug', 'seller'))->get();

        return view('admin.products.create', compact('categories', 'sellers'));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $this->productService->create(
            $this->prepareData($request),
            $request->file('main_image'),
            $request->file('gallery', [])
        );

        return redirect()->route('admin.products.index')->with('success', 'Produto criado com sucesso.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        $sellers = User::whereHas('role', fn ($q) => $q->where('slug', 'seller'))->get();

        return view('admin.products.edit', compact('product', 'categories', 'sellers'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->productService->update(
            $product,
            $this->prepareData($request),
            $request->file('main_image'),
            $request->file('gallery', [])
        );

        return redirect()->route('admin.products.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->productService->delete($product);

        return back()->with('success', 'Produto eliminado com sucesso.');
    }

    public function approve(Product $product): RedirectResponse
    {
        $product->update([
            'approval_status' => ApprovalStatus::Approved,
            'is_active' => true,
        ]);

        return back()->with('success', 'Produto aprovado e publicado.');
    }

    public function reject(Product $product): RedirectResponse
    {
        $product->update([
            'approval_status' => ApprovalStatus::Rejected,
            'is_active' => false,
        ]);

        return back()->with('success', 'Produto reprovado.');
    }

    public function toggleFeatured(Product $product): RedirectResponse
    {
        $product->update(['is_featured' => ! $product->is_featured]);

        $message = $product->is_featured ? 'Produto destacado.' : 'Destaque removido.';

        return back()->with('success', $message);
    }

    protected function prepareData(ProductRequest $request): array
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['user_id'] = $request->input('user_id', auth()->id());
        $data['approval_status'] = ApprovalStatus::Approved;

        return $data;
    }
}
