@extends('layouts.seller')

@section('title', 'Pedidos')

@section('content')
<h1 class="h3 mb-4">Pedidos com Meus Produtos</h1>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>Pedido</th><th>Cliente</th><th>Data</th><th>Total</th><th>Estado</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>{{ $order->formatted_total }}</td>
                        <td><span class="badge {{ $order->status->badgeClass() }}">{{ $order->status->label() }}</span></td>
                        <td><a href="{{ route('seller.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Ver</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">Sem pedidos</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
