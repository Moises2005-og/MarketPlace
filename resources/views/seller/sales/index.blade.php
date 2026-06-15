@extends('layouts.seller')

@section('title', 'Histórico de Vendas')

@section('content')
<h1 class="h3 mb-1">Histórico de Vendas</h1>
<p class="text-muted mb-4">Todas as vendas realizadas na plataforma</p>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card success shadow-sm"><div class="card-body d-flex justify-content-between align-items-center">
            <div><div class="text-muted small">Receita Total</div><div class="fs-5 fw-bold">{{ money($stats['total_sales']) }}</div></div>
            <div class="stat-icon bg-success-soft"><i class="bi bi-cash-coin"></i></div>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card shadow-sm"><div class="card-body d-flex justify-content-between align-items-center">
            <div><div class="text-muted small">Itens Vendidos</div><div class="fs-3 fw-bold">{{ $stats['total_items'] }}</div></div>
            <div class="stat-icon bg-primary-soft"><i class="bi bi-box-seam"></i></div>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card warning shadow-sm"><div class="card-body d-flex justify-content-between align-items-center">
            <div><div class="text-muted small">Pedidos</div><div class="fs-3 fw-bold">{{ $stats['orders'] }}</div></div>
            <div class="stat-icon bg-warning-soft"><i class="bi bi-receipt"></i></div>
        </div></div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th></th><th>Data</th><th>Produto</th><th>Cliente</th><th>Qtd</th><th>Subtotal</th><th>Pedido</th></tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>
                            @if($sale->product)
                                <img src="{{ $sale->product->main_image_url }}" width="40" height="40" class="rounded" style="object-fit:cover">
                            @else
                                <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:40px;height:40px"><i class="bi bi-box text-muted"></i></div>
                            @endif
                        </td>
                        <td class="small">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td class="fw-semibold">{{ Str::limit($sale->product_name, 30) }}</td>
                        <td>{{ $sale->order->user->name }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td class="fw-semibold text-success">{{ money($sale->subtotal) }}</td>
                        <td><a href="{{ route('seller.orders.show', $sale->order) }}" class="btn btn-sm btn-outline-primary">{{ $sale->order->order_number }}</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-muted text-center py-5">Ainda não tem vendas registadas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $sales->links() }}</div>
@endsection
