@extends('layouts.admin')

@section('title', 'Pedido '.$order->order_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Pedido {{ $order->order_number }}</h1>
    <span class="badge {{ $order->status->badgeClass() }} fs-6">{{ $order->status->label() }}</span>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white fw-semibold">Itens</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light"><tr><th>Produto</th><th>Vendedor</th><th>Qtd</th><th>Subtotal</th></tr></thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }} <small class="text-muted">({{ $item->sku }})</small></td>
                                <td>{{ $item->seller->name }}</td>
                                <td>{{ $item->quantity }}</td>
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
            <div class="card-header bg-white fw-semibold">Cliente</div>
            <div class="card-body">
                <p class="mb-1 fw-semibold">{{ $order->user->name }}</p>
                <p class="text-muted small mb-0">{{ $order->user->email }}</p>
            </div>
        </div>
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold">Entrega</div>
            <div class="card-body"><p class="mb-0">{{ $order->shipping_address }}</p></div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">Alterar Estado</div>
            <div class="card-body">
                <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select mb-3">
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}" @selected($order->status === $status)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary w-100">Atualizar</button>
                </form>
                <div class="mt-3 text-end fw-bold fs-5">Total: {{ $order->formatted_total }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
