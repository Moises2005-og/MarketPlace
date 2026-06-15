@extends('layouts.admin')

@section('title', 'Produtos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Gestão de Produtos</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Novo</a>
</div>

<div class="btn-group mb-3">
    <a href="{{ route('admin.products.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">Todos</a>
    <a href="{{ route('admin.products.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') === 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">Pendentes</a>
    <a href="{{ route('admin.products.index', ['status' => 'approved']) }}" class="btn btn-sm {{ request('status') === 'approved' ? 'btn-success' : 'btn-outline-success' }}">Aprovados</a>
    <a href="{{ route('admin.products.index', ['status' => 'rejected']) }}" class="btn btn-sm {{ request('status') === 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">Reprovados</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th></th><th>Nome</th><th>Categoria</th><th>Vendedor</th><th>Preço</th><th>Stock</th><th>Aprovação</th><th>Estado</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td><img src="{{ $product->main_image_url }}" width="48" height="48" class="rounded shadow-sm" style="object-fit:cover"></td>
                        <td>{{ Str::limit($product->name, 28) }}</td>
                        <td><span class="badge rounded-pill" style="background:var(--mp-primary-soft);color:var(--mp-primary-dark)">{{ $product->category->name ?? '—' }}</span></td>
                        <td>{{ $product->seller->name }}</td>
                        <td>{{ $product->formatted_price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td><span class="badge {{ $product->approval_status->badgeClass() }}">{{ $product->approval_status->label() }}</span></td>
                        <td>
                            @if($product->is_active)<span class="badge bg-success">Ativo</span>@else<span class="badge bg-secondary">Inativo</span>@endif
                            @if($product->is_featured)<span class="badge bg-warning text-dark">Destaque</span>@endif
                        </td>
                        <td class="text-end text-nowrap">
                            @if($product->approval_status->value === 'pending')
                                <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success" title="Aprovar"><i class="bi bi-check-lg"></i></button>
                                </form>
                                <form action="{{ route('admin.products.reject', $product) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-danger" data-confirm="Reprovar este produto?" title="Reprovar"><i class="bi bi-x-lg"></i></button>
                                </form>
                            @endif
                            <form action="{{ route('admin.products.featured', $product) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-warning" title="{{ $product->is_featured ? 'Remover destaque' : 'Destacar' }}">
                                    <i class="bi bi-star{{ $product->is_featured ? '-fill' : '' }}"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary" title="Editar"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" data-confirm="Eliminar este produto?" title="Eliminar"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $products->links() }}</div>
@endsection
