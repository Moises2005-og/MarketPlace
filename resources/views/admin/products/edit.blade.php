@extends('layouts.admin')

@section('title', 'Editar Produto')

@section('content')
<h1 class="h3 mb-4">Editar Produto</h1>
<div class="card shadow-sm"><div class="card-body">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('admin.products._form', ['product' => $product])
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div></div>
@endsection
