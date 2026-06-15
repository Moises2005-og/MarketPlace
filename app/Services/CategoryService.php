<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public function create(array $data, ?UploadedFile $image = null): Category
    {
        if ($image) {
            $data['image'] = $image->store('categories', 'public');
        }

        return Category::create($data);
    }

    public function update(Category $category, array $data, ?UploadedFile $image = null): Category
    {
        if ($image) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $image->store('categories', 'public');
        }

        $category->update($data);

        return $category->fresh();
    }

    public function delete(Category $category): void
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();
    }
}
