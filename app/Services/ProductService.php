<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function create(array $data, ?UploadedFile $mainImage = null, array $gallery = []): Product
    {
        if ($mainImage) {
            $data['main_image'] = $this->storeImage($mainImage);
        }

        $product = Product::create($data);
        $this->syncGallery($product, $gallery);

        return $product->load(['category', 'seller', 'images']);
    }

    public function update(Product $product, array $data, ?UploadedFile $mainImage = null, array $gallery = []): Product
    {
        if ($mainImage) {
            $this->deleteImage($product->main_image);
            $data['main_image'] = $this->storeImage($mainImage);
        }

        $product->update($data);
        $this->syncGallery($product, $gallery);

        return $product->fresh(['category', 'seller', 'images']);
    }

    public function delete(Product $product): void
    {
        $this->deleteImage($product->main_image);

        foreach ($product->images as $image) {
            $this->deleteImage($image->image_path);
        }

        $product->delete();
    }

    public function search(array $filters = [])
    {
        $query = Product::with(['category', 'seller'])
            ->published()
            ->search($filters['q'] ?? null);

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['category_slug'])) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $filters['category_slug']));
        }

        if (isset($filters['min_price']) && $filters['min_price'] !== '') {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price']) && $filters['max_price'] !== '') {
            $query->where('price', '<=', $filters['max_price']);
        }

        $sort = $filters['sort'] ?? 'newest';

        return match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'),
            default => $query->latest(),
        };
    }

    protected function storeImage(UploadedFile $file): string
    {
        return $file->store('products', 'public');
    }

    protected function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    protected function syncGallery(Product $product, array $gallery): void
    {
        foreach ($gallery as $index => $file) {
            if ($file instanceof UploadedFile) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $this->storeImage($file),
                    'sort_order' => $index,
                ]);
            }
        }
    }
}
