@extends('layouts.seller')

@section('title', 'Meus Produtos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Meus Produtos</h1>
        <p class="text-muted mb-0">{{ $products->total() }} produto(s) na sua loja</p>
    </div>
    <a href="{{ route('seller.products.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Novo Produto</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width:60px"></th>
                    <th>Produto</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Stock</th>
                    <th>Views</th>
                    <th>Aprovação</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <img src="{{ $product->main_image_url }}" width="48" height="48" class="rounded shadow-sm" style="object-fit:cover">
                        </td>
                        <td>
                            <div class="fw-semibold">{{ Str::limit($product->name, 35) }}</div>
                            <small class="text-muted">SKU: {{ $product->sku }}</small>
                        </td>
                        <td><span class="badge rounded-pill" style="background:var(--mp-primary-soft);color:var(--mp-primary-dark)">{{ $product->category->name ?? '—' }}</span></td>
                        <td class="fw-semibold" style="color:var(--mp-primary-dark)">{{ $product->formatted_price }}</td>
                        <td>
                            @if($product->stock <= 5)
                                <span class="badge bg-danger">{{ $product->stock }}</span>
                            @elseif($product->stock <= 15)
                                <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                            @else
                                <span class="badge bg-success">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td><i class="bi bi-eye text-muted me-1"></i>{{ number_format($product->view_count) }}</td>
                        <td><span class="badge {{ $product->approval_status->badgeClass() }}">{{ $product->approval_status->label() }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-sm btn-outline-primary" title="Editar"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" data-confirm="Eliminar este produto?" title="Eliminar"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-box display-4 d-block mb-2 opacity-25"></i>
                            Ainda não tem produtos. <a href="{{ route('seller.products.create') }}">Criar o primeiro</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $products->links() }}</div>
@endsection
