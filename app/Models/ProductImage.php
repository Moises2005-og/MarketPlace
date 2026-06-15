<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Support\ProductImageCatalog;
use App\Support\PublicStorage;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
        'sort_order',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string
    {
        $url = PublicStorage::url($this->image_path);

        if ($url) {
            return $url;
        }

        $this->loadMissing('product.category');

        return ProductImageCatalog::urlForCategory(
            $this->product?->category?->slug,
            ($this->product_id * 10) + $this->sort_order
        );
    }
}
