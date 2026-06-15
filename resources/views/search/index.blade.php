@extends('layouts.app')

@section('title', 'Pesquisa')

@section('content')
<div class="row">
    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold"><i class="bi bi-funnel me-2"></i>Filtros</div>
            <div class="card-body">
                <form action="{{ route('search') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label">Pesquisa</label>
                        <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="Nome do produto...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoria</label>
                        <select name="category_id" class="form-select">
                            <option value="">Todas</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Preço min.</label>
                            <input type="number" name="min_price" class="form-control" step="0.01" value="{{ request('min_price') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Preço máx.</label>
                            <input type="number" name="max_price" class="form-control" step="0.01" value="{{ request('max_price') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ordenar</label>
                        <select name="sort" class="form-select">
                            <option value="newest" @selected(request('sort') === 'newest')>Mais recentes</option>
                            <option value="price_asc" @selected(request('sort') === 'price_asc')>Preço: menor</option>
                            <option value="price_desc" @selected(request('sort') === 'price_desc')>Preço: maior</option>
                            <option value="name" @selected(request('sort') === 'name')>Nome A-Z</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Aplicar Filtros</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4 mb-0">
                @if(request('q'))
                    Resultados para "{{ request('q') }}"
                @else
                    Todos os Produtos
                @endif
            </h1>
            <span class="text-muted">{{ $products->total() }} produto(s)</span>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-search display-1 text-muted"></i>
                <p class="mt-3 text-muted">Nenhum produto encontrado.</p>
            </div>
        @else
            <div class="row g-3">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="mt-4">{{ $products->links() }}</div>
        @endif
    </div>
</div>
@endsection
