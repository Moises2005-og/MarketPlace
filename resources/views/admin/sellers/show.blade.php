@extends('layouts.admin')

@section('title', 'Vendedor — '.$seller->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.sellers.index') }}" class="text-decoration-none small"><i class="bi bi-arrow-left"></i> Voltar</a>
        <h1 class="h3 mb-0 mt-1">{{ $seller->name }}</h1>
    </div>
    <span class="badge {{ $seller->status->badgeClass() }} fs-6">{{ $seller->status->label() }}</span>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card shadow-sm"><div class="card-body"><div class="text-muted small">Produtos</div><div class="fs-3 fw-bold">{{ $stats['products'] }}</div></div></div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card success shadow-sm"><div class="card-body"><div class="text-muted small">Vendas Totais</div><div class="fs-5 fw-bold">{{ money($stats['total_sales']) }}</div></div></div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card warning shadow-sm"><div class="card-body"><div class="text-muted small">Pedidos</div><div class="fs-3 fw-bold">{{ $stats['orders'] }}</div></div></div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white fw-semibold">Contactos</div>
    <div class="card-body">
        <p class="mb-1"><strong>Email:</strong> {{ $seller->email }}</p>
        <p class="mb-0"><strong>Telefone:</strong> {{ $seller->phone ?? '—' }}</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold">Histórico de Vendas</div>
    <div class="table-responsive">
        <table class="table table-sm mb-0">
            <thead class="table-light">
                <tr><th>Data</th><th>Produto</th><th>Qtd</th><th>Subtotal</th><th>Pedido</th></tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                        <td>{{ $sale->product_name }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>{{ money($sale->subtotal) }}</td>
                        <td><a href="{{ route('admin.orders.show', $sale->order) }}">{{ $sale->order->order_number }}</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted text-center py-3">Sem vendas registadas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $sales->links() }}</div>
@endsection
