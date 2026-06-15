<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function index(): View
    {
        $categories = Category::withCount('products')->latest()->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.categories.create', compact('categories'));
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $this->categoryService->create(
            $this->prepareData($request),
            $request->file('image')
        );

        return redirect()->route('admin.categories.index')->with('success', 'Categoria criada com sucesso.');
    }

    public function edit(Category $category): View
    {
        $categories = Category::where('id', '!=', $category->id)->orderBy('name')->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $this->categoryService->update(
            $category,
            $this->prepareData($request),
            $request->file('image')
        );

        return redirect()->route('admin.categories.index')->with('success', 'Categoria atualizada com sucesso.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Não é possível eliminar uma categoria com produtos.');
        }

        $this->categoryService->delete($category);

        return back()->with('success', 'Categoria eliminada com sucesso.');
    }

    protected function prepareData(CategoryRequest $request): array
    {
        return [
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
        ];
    }
}
