@extends('layouts.seller')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Olá, {{ auth()->user()->name }}!</h1>
        <p class="text-muted mb-0">Resumo da sua loja</p>
    </div>
    <a href="{{ route('seller.products.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Novo Produto</a>
</div>

@if($stats['pending_products'] > 0)
    <div class="alert alert-warning d-flex align-items-center mb-4">
        <i class="bi bi-hourglass-split fs-4 me-3"></i>
        <div>Tem <strong>{{ $stats['pending_products'] }}</strong> produto(s) aguardando aprovação do administrador.</div>
    </div>
@endif

@if($stats['low_stock'] > 0)
    <div class="alert alert-danger d-flex align-items-center mb-4">
        <i class="bi bi-exclamation-triangle fs-4 me-3"></i>
        <div><strong>{{ $stats['low_stock'] }}</strong> produto(s) com stock baixo. <a href="{{ route('seller.products.index') }}" class="alert-link">Ver produtos</a></div>
    </div>
@endif

<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card stat-card shadow-sm h-100"><div class="card-body text-center">
            <div class="stat-icon mx-auto mb-2 bg-primary-soft"><i class="bi bi-box"></i></div>
            <div class="fs-4 fw-bold">{{ $stats['products'] }}</div>
            <div class="text-muted small">Produtos</div>
        </div></div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card stat-card success shadow-sm h-100"><div class="card-body text-center">
            <div class="stat-icon mx-auto mb-2 bg-success-soft"><i class="bi bi-check-circle"></i></div>
            <div class="fs-4 fw-bold">{{ $stats['active_products'] }}</div>
            <div class="text-muted small">Publicados</div>
        </div></div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card stat-card warning shadow-sm h-100"><div class="card-body text-center">
            <div class="stat-icon mx-auto mb-2 bg-warning-soft"><i class="bi bi-hourglass"></i></div>
            <div class="fs-4 fw-bold">{{ $stats['pending_products'] }}</div>
            <div class="text-muted small">Pendentes</div>
        </div></div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card stat-card shadow-sm h-100"><div class="card-body text-center">
            <div class="stat-icon mx-auto mb-2 bg-primary-soft"><i class="bi bi-eye"></i></div>
            <div class="fs-4 fw-bold">{{ number_format($stats['total_views']) }}</div>
            <div class="text-muted small">Visualizações</div>
        </div></div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card stat-card success shadow-sm h-100"><div class="card-body text-center">
            <div class="stat-icon mx-auto mb-2 bg-success-soft"><i class="bi bi-cash-coin"></i></div>
            <div class="fs-6 fw-bold">{{ money($stats['total_sales']) }}</div>
            <div class="text-muted small">Vendas</div>
        </div></div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card stat-card shadow-sm h-100"><div class="card-body text-center">
            <div class="stat-icon mx-auto mb-2 bg-primary-soft"><i class="bi bi-receipt"></i></div>
            <div class="fs-4 fw-bold">{{ $stats['orders'] }}</div>
            <div class="text-muted small">Pedidos</div>
        </div></div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between">
                <span><i class="bi bi-grid me-2"></i>Meus Produtos</span>
                <a href="{{ route('seller.products.index') }}" class="small">Ver todos</a>
            </div>
            <div class="row g-0">
                @forelse($recentProducts as $product)
                    <div class="col-md-6 col-lg-4">
                        <div class="product-mini-card p-3 border-bottom border-end">
                            <img src="{{ $product->main_image_url }}" alt="" class="product-mini-img mb-2">
                            <div class="small fw-semibold text-truncate">{{ $product->name }}</div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <span class="small fw-bold" style="color:var(--mp-primary-dark)">{{ $product->formatted_price }}</span>
                                <span class="badge {{ $product->approval_status->badgeClass() }}">{{ $product->approval_status->label() }}</span>
                            </div>
                            <div class="small text-muted mt-1">
                                <i class="bi bi-box me-1"></i>{{ $product->stock }} em stock
                                · <i class="bi bi-eye me-1"></i>{{ $product->view_count }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 p-4 text-center text-muted">
                        <i class="bi bi-box display-4 d-block mb-2 opacity-25"></i>
                        Ainda não tem produtos. <a href="{{ route('seller.products.create') }}">Criar o primeiro</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        @if($lowStockProducts->isNotEmpty())
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white fw-semibold"><i class="bi bi-exclamation-triangle text-warning me-2"></i>Stock Baixo</div>
            <ul class="list-group list-group-flush">
                @foreach($lowStockProducts as $product)
                    <li class="list-group-item d-flex align-items-center gap-2">
                        <img src="{{ $product->main_image_url }}" alt="" class="rounded" width="32" height="32" style="object-fit:cover">
                        <div class="flex-grow-1 min-w-0">
                            <div class="small fw-semibold text-truncate">{{ $product->name }}</div>
                        </div>
                        <span class="badge bg-danger">{{ $product->stock }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold"><i class="bi bi-bar-chart me-2"></i>Mais Visualizados</div>
            <ul class="list-group list-group-flush">
                @forelse($topViewed as $product)
                    <li class="list-group-item d-flex align-items-center gap-2">
                        <img src="{{ $product->main_image_url }}" alt="" class="rounded" width="32" height="32" style="object-fit:cover">
                        <div class="flex-grow-1 min-w-0 small text-truncate">{{ $product->name }}</div>
                        <span class="badge bg-light text-dark"><i class="bi bi-eye"></i> {{ $product->view_count }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center small">Sem dados</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold d-flex justify-content-between">
        <span><i class="bi bi-graph-up me-2"></i>Vendas Recentes</span>
        <a href="{{ route('seller.sales.index') }}" class="small">Ver histórico</a>
    </div>
    <div class="table-responsive">
        <table class="table table-sm mb-0 align-middle">
            <thead><tr><th>Produto</th><th>Qtd</th><th>Valor</th><th>Data</th></tr></thead>
            <tbody>
                @forelse($recentSales as $sale)
                    <tr>
                        <td>{{ Str::limit($sale->product_name, 30) }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td class="fw-semibold text-success">{{ money($sale->subtotal) }}</td>
                        <td class="text-muted small">{{ $sale->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-muted text-center py-3">Sem vendas registadas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
