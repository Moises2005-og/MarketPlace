@extends('layouts.app')

@section('title', $category->name)

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Loja</a></li>
        <li class="breadcrumb-item active">{{ $category->name }}</li>
    </ol>
</nav>

<div class="card border-0 shadow-sm mb-4 overflow-hidden" style="border-radius: 1rem;">
    <div class="row g-0">
        @if($category->image_url)
            <div class="col-md-4">
                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="img-fluid h-100 w-100" style="object-fit: cover; min-height: 180px;">
            </div>
        @endif
        <div class="col-md-{{ $category->image_url ? '8' : '12' }}">
            <div class="card-body p-4">
                <h1 class="h3 mb-2">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="text-muted mb-0">{{ $category->description }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

@if($products->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-box display-1 text-muted"></i>
        <p class="mt-3 text-muted">Nenhum produto nesta categoria.</p>
    </div>
@else
    <div class="row g-3">
        @foreach($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
@endif
@endsection
