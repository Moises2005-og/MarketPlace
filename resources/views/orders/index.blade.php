@extends('layouts.app')

@section('title', 'Meus Pedidos')

@section('content')
<h1 class="h3 mb-4"><i class="bi bi-box-seam me-2"></i>Meus Pedidos</h1>

@if($orders->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-inbox display-1 text-muted"></i>
        <p class="mt-3 text-muted">Ainda não tem pedidos.</p>
        <a href="{{ route('search') }}" class="btn btn-primary">Começar a Comprar</a>
    </div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Pedido</th>
                        <th>Data</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="fw-semibold">{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $order->formatted_total }}</td>
                            <td><span class="badge {{ $order->status->badgeClass() }}">{{ $order->status->label() }}</span></td>
                            <td><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Ver</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
@endif
@endsection
