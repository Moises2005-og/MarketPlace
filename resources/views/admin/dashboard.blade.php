@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Dashboard Administrativo</h1>
        <p class="text-muted mb-0">Visão geral da plataforma</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Novo Produto</a>
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-shop me-1"></i>Loja</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">Vendedores</div>
                        <div class="fs-3 fw-bold">{{ $stats['sellers'] }}</div>
                        @if($stats['pending_sellers'] > 0)
                            <a href="{{ route('admin.sellers.index') }}" class="small text-warning">{{ $stats['pending_sellers'] }} pendente(s)</a>
                        @endif
                    </div>
                    <div class="stat-icon bg-primary-soft"><i class="bi bi-shop"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">Produtos Publicados</div>
                        <div class="fs-3 fw-bold">{{ $stats['published'] }}</div>
                        <span class="small text-muted">de {{ $stats['products'] }} total</span>
                    </div>
                    <div class="stat-icon bg-primary-soft"><i class="bi bi-box"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card success shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">Receita Total</div>
                        <div class="fs-5 fw-bold">{{ money($stats['sales']) }}</div>
                        <span class="small text-muted">{{ $stats['orders'] }} pedidos</span>
                    </div>
                    <div class="stat-icon bg-success-soft"><i class="bi bi-cash-coin"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card danger shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">Aprovações Pendentes</div>
                        <div class="fs-3 fw-bold">{{ $stats['pending_products'] }}</div>
                        @if($stats['low_stock'] > 0)
                            <span class="small text-danger">{{ $stats['low_stock'] }} stock baixo</span>
                        @endif
                    </div>
                    <div class="stat-icon bg-danger-soft"><i class="bi bi-hourglass-split"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white fw-semibold"><i class="bi bi-pie-chart me-2"></i>Produtos por Categoria</div>
            <ul class="list-group list-group-flush">
                @forelse($categoryStats as $cat)
                    <li class="list-group-item d-flex align-items-center gap-3">
                        @if($cat->image_url)
                            <img src="{{ $cat->image_url }}" alt="" class="rounded" width="40" height="40" style="object-fit:cover">
                        @else
                            <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:40px;height:40px"><i class="bi bi-tag text-muted"></i></div>
                        @endif
                        <div class="flex-grow-1">
                            <div class="fw-semibold small">{{ $cat->name }}</div>
                            <div class="progress mt-1" style="height:4px">
                                <div class="progress-bar" style="width: {{ $stats['products'] > 0 ? ($cat->products_count / $stats['products'] * 100) : 0 }}%; background: var(--mp-primary);"></div>
                            </div>
                        </div>
                        <span class="badge rounded-pill" style="background:var(--mp-primary-soft);color:var(--mp-primary-dark)">{{ $cat->products_count }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center">Sem categorias</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white fw-semibold"><i class="bi bi-trophy me-2"></i>Produtos Mais Vendidos</div>
            <ul class="list-group list-group-flush">
                @forelse($topProducts as $i => $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-light text-dark">{{ $i + 1 }}</span>
                            <span class="small">{{ Str::limit($item->product_name, 28) }}</span>
                        </div>
                        <span class="small fw-semibold text-success">{{ $item->total_qty }} un.</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center">Sem vendas ainda</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between">
                <span><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Stock Baixo</span>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($lowStockProducts as $product)
                    <li class="list-group-item d-flex align-items-center gap-2">
                        <img src="{{ $product->main_image_url }}" alt="" class="rounded" width="36" height="36" style="object-fit:cover">
                        <div class="flex-grow-1 min-w-0">
                            <div class="small fw-semibold text-truncate">{{ $product->name }}</div>
                            <div class="small text-muted">{{ $product->seller->name }}</div>
                        </div>
                        <span class="badge bg-warning text-dark">{{ $product->stock }} un.</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center">Stock OK em todos os produtos</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between">
                <span><i class="bi bi-hourglass me-2"></i>Produtos Pendentes</span>
                <a href="{{ route('admin.products.index', ['status' => 'pending']) }}" class="small">Ver todos</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0 align-middle">
                    <thead><tr><th></th><th>Produto</th><th>Vendedor</th><th></th></tr></thead>
                    <tbody>
                        @forelse($pendingProducts as $product)
                            <tr>
                                <td><img src="{{ $product->main_image_url }}" width="36" height="36" class="rounded" style="object-fit:cover"></td>
                                <td>{{ Str::limit($product->name, 22) }}</td>
                                <td>{{ $product->seller->name }}</td>
                                <td class="text-end text-nowrap">
                                    <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                    <form action="{{ route('admin.products.reject', $product) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-outline-danger" data-confirm="Reprovar?"><i class="bi bi-x-lg"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-muted text-center py-3">Nenhum produto pendente</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between">
                <span><i class="bi bi-person-check me-2"></i>Vendedores Pendentes</span>
                <a href="{{ route('admin.sellers.index') }}" class="small">Ver todos</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0 align-middle">
                    <thead><tr><th>Nome</th><th>Email</th><th></th></tr></thead>
                    <tbody>
                        @forelse($pendingSellers as $seller)
                            <tr>
                                <td>{{ $seller->name }}</td>
                                <td>{{ $seller->email }}</td>
                                <td class="text-end text-nowrap">
                                    <form action="{{ route('admin.sellers.approve', $seller) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                    <form action="{{ route('admin.sellers.reject', $seller) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-outline-danger" data-confirm="Reprovar?"><i class="bi bi-x-lg"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-muted text-center py-3">Nenhum vendedor pendente</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-header bg-white fw-semibold"><i class="bi bi-receipt me-2"></i>Pedidos Recentes</div>
    <div class="table-responsive">
        <table class="table table-sm mb-0 align-middle">
            <thead><tr><th>Pedido</th><th>Cliente</th><th>Total</th><th>Estado</th><th></th></tr></thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td class="fw-semibold">{{ $order->order_number }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->formatted_total }}</td>
                        <td><span class="badge {{ $order->status->badgeClass() }}">{{ $order->status->label() }}</span></td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Ver</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted text-center py-3">Sem pedidos</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
