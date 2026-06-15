@extends('layouts.app')

@section('title', 'Pedido '.$order->order_number)

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Pedidos</a></li>
        <li class="breadcrumb-item active">{{ $order->order_number }}</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h3 mb-1">Pedido {{ $order->order_number }}</h1>
        <p class="text-muted mb-0">{{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <span class="badge {{ $order->status->badgeClass() }} fs-6">{{ $order->status->label() }}</span>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">Itens do Pedido</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produto</th>
                            <th>Qtd</th>
                            <th>Preço</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $item->product_name }}</div>
                                    <small class="text-muted">SKU: {{ $item->sku }} | Vendedor: {{ $item->seller->name }}</small>
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ money($item->price) }}</td>
                                <td>{{ money($item->subtotal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold">Entrega</div>
            <div class="card-body">
                <p class="mb-1">{{ $order->shipping_address }}</p>
                @if($order->phone)<p class="text-muted mb-0">{{ $order->phone }}</p>@endif
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><span>{{ money($order->subtotal) }}</span></div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5"><span>Total</span><span class="text-primary">{{ $order->formatted_total }}</span></div>
                @if($order->canCancel())
                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="mt-3">
                        @csrf
                        <button class="btn btn-outline-danger w-100" data-confirm="Tem a certeza que deseja cancelar este pedido?">Cancelar Pedido</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
