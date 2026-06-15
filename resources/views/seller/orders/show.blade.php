@extends('layouts.seller')

@section('title', 'Pedido '.$order->order_number)

@section('content')
<h1 class="h3 mb-4">Pedido {{ $order->order_number }}</h1>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">Meus Itens neste Pedido</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light"><tr><th>Produto</th><th>Qtd</th><th>Preço</th><th>Subtotal</th></tr></thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
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
        <div class="card shadow-sm">
            <div class="card-body">
                <p><strong>Cliente:</strong> {{ $order->user->name }}</p>
                <p><strong>Estado:</strong> <span class="badge {{ $order->status->badgeClass() }}">{{ $order->status->label() }}</span></p>
                <p><strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-0"><strong>Entrega:</strong> {{ $order->shipping_address }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
