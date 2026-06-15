@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<h1 class="h3 mb-4"><i class="bi bi-credit-card me-2"></i>Finalizar Compra</h1>

<div class="row">
    <div class="col-lg-7">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white fw-semibold">Dados de Entrega</div>
            <div class="card-body">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Endereço de Entrega *</label>
                        <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" rows="3" required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                        @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notas (opcional)</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-check-circle me-2"></i>Confirmar Pedido
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">Resumo do Pedido</div>
            <div class="card-body">
                @foreach($cart->items as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                        <span>{{ money($item->subtotal) }}</span>
                    </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span class="text-primary">{{ money($cart->subtotal) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
