@extends('layouts.app')

@section('title', $product->name)

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
        <li class="breadcrumb-item"><a href="{{ route('categories.show', $product->category->slug) }}">{{ $product->category->name }}</a></li>
        <li class="breadcrumb-item active">{{ Str::limit($product->name, 40) }}</li>
    </ol>
</nav>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card shadow-sm p-3">
            <img id="productMainImage" src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="img-fluid product-main-image w-100 mb-3">
            @if($product->images->isNotEmpty())
                <div class="d-flex gap-2 flex-wrap">
                    <img src="{{ $product->main_image_url }}" class="product-gallery-thumb active" data-src="{{ $product->main_image_url }}" alt="">
                    @foreach($product->images as $image)
                        <img src="{{ $image->url }}" class="product-gallery-thumb" data-src="{{ $image->url }}" alt="">
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <h1 class="h3 mb-2">{{ $product->name }}</h1>
        <p class="text-muted mb-1">SKU: {{ $product->sku }}</p>
        <p class="text-muted mb-3">
            Vendido por <strong>{{ $product->seller->name }}</strong>
        </p>
        <p class="price display-6 text-primary mb-3">{{ $product->formatted_price }}</p>

        @if($product->isInStock())
            <span class="badge bg-success mb-3">Em stock ({{ $product->stock }} unidades)</span>
        @else
            <span class="badge bg-danger mb-3">Esgotado</span>
        @endif

        @if($product->isInStock())
            <form action="{{ route('cart.store') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <label class="form-label mb-0">Quantidade:</label>
                    <div class="input-group" style="width: 140px;">
                        <button type="button" class="btn btn-outline-secondary" data-qty-minus>-</button>
                        <input type="number" name="quantity" class="form-control text-center" data-qty-input value="1" min="1" max="{{ $product->stock }}">
                        <button type="button" class="btn btn-outline-secondary" data-qty-plus>+</button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-cart-plus me-2"></i>Adicionar ao Carrinho
                </button>
            </form>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Descrição</h5>
                <p class="card-text text-muted">{{ $product->description }}</p>
            </div>
        </div>
    </div>
</div>

@if($relatedProducts->isNotEmpty())
<section class="mt-5">
    <h2 class="section-title">Produtos Relacionados</h2>
    <div class="row g-3">
        @foreach($relatedProducts as $related)
            <x-product-card :product="$related" />
        @endforeach
    </div>
</section>
@endif
@endsection
