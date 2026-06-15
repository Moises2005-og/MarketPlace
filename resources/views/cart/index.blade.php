@extends('layouts.app')

@section('title', 'Carrinho')

@section('content')
<h1 class="h3 mb-4"><i class="bi bi-cart3 me-2"></i>Carrinho de Compras</h1>

@if($cart->items->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-cart-x display-1 text-muted"></i>
        <p class="mt-3 text-muted">O seu carrinho está vazio.</p>
        <a href="{{ route('search') }}" class="btn btn-primary">Continuar a Comprar</a>
    </div>
@else
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Produto</th>
                                <th>Preço</th>
                                <th>Qtd</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $item->product->main_image_url }}" alt="" width="60" height="60" class="rounded object-fit-cover">
                                            <div>
                                                <a href="{{ route('products.show', $item->product->slug) }}" class="text-decoration-none fw-semibold">
                                                    {{ $item->product->name }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ money($item->price) }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex">
                                            @csrf @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="0" max="{{ $item->product->stock }}" class="form-control form-control-sm" style="width:70px" onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="fw-semibold">{{ money($item->subtotal) }}</td>
                                    <td>
                                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Resumo</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span class="fw-semibold">{{ money($cart->subtotal) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold text-primary fs-5">{{ money($cart->subtotal) }}</span>
                    </div>
                    @auth
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 btn-lg">Finalizar Compra</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100">Entrar para Comprar</a>
                    @endauth
                    <a href="{{ route('search') }}" class="btn btn-outline-secondary w-100 mt-2">Continuar a Comprar</a>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
