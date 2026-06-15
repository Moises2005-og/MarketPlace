@props(['product'])

<div class="col-6 col-md-4 col-lg-3">
    <div class="card product-card shadow-sm">
        <a href="{{ route('products.show', $product->slug) }}">
            <img src="{{ $product->main_image_url }}" class="card-img-top" alt="{{ $product->name }}" loading="lazy">
        </a>
        <div class="card-body d-flex flex-column">
            <small class="text-muted">{{ $product->category->name ?? '' }}</small>
            <h6 class="card-title mt-1 mb-2">
                <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark stretched-link-title">
                    {{ Str::limit($product->name, 50) }}
                </a>
            </h6>
            <div class="mt-auto">
                <p class="price mb-1">{{ $product->formatted_price }}</p>
                @if($product->isInStock())
                    <span class="badge bg-success badge-stock">Em stock</span>
                @else
                    <span class="badge bg-danger badge-stock">Esgotado</span>
                @endif
            </div>
        </div>
    </div>
</div>
