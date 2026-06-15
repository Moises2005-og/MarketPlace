@extends('layouts.app')

@section('title', 'Loja')

@section('content')
<div class="hero-banner">
    <div class="row align-items-center">
        <div class="col-lg-7">
            <h1 class="display-5 fw-bold mb-3">Encontre os melhores produtos</h1>
            <p class="lead mb-4 opacity-90">Milhares de produtos com os melhores preços. Compre com segurança e receba em casa.</p>
            <a href="{{ route('search') }}" class="btn btn-light btn-lg fw-semibold" style="color: var(--mp-primary-dark);">
                <i class="bi bi-search me-2"></i>Explorar Produtos
            </a>
        </div>
        <div class="col-lg-5 d-none d-lg-block text-center">
            <i class="bi bi-bag-check" style="font-size: 8rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

@if($categories->isNotEmpty())
<section class="mb-5">
    <h2 class="section-title">Categorias</h2>
    <div class="row g-3">
        @foreach($categories as $category)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('categories.show', $category->slug) }}" class="category-card">
                    @if($category->image_url)
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="category-card-img" loading="lazy">
                    @else
                        <div class="category-card-img d-flex align-items-center justify-content-center" style="background: var(--mp-primary-soft);">
                            <i class="bi bi-tag fs-1 text-primary opacity-50"></i>
                        </div>
                    @endif
                    <div class="category-card-body">
                        <div class="category-card-title">{{ $category->name }}</div>
                        <span class="badge rounded-pill" style="background: var(--mp-primary-soft); color: var(--mp-primary-dark);">
                            {{ $category->products_count }} produtos
                        </span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</section>
@endif

@if($featuredProducts->isNotEmpty())
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="section-title mb-0">Produtos em Destaque</h2>
        <a href="{{ route('search', ['sort' => 'newest']) }}" class="text-decoration-none" style="color: var(--mp-primary-dark);">Ver todos <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-3">
        @foreach($featuredProducts as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</section>
@endif

@if($recentProducts->isNotEmpty())
<section class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="section-title mb-0">Produtos Recentes</h2>
        <a href="{{ route('search') }}" class="text-decoration-none" style="color: var(--mp-primary-dark);">Ver todos <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-3">
        @foreach($recentProducts as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</section>
@endif
@endsection
