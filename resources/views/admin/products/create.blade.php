@extends('layouts.admin')

@section('title', 'Novo Produto')

@section('content')
<h1 class="h3 mb-4">Novo Produto</h1>
<div class="card shadow-sm"><div class="card-body">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.products._form')
        <button type="submit" class="btn btn-primary">Criar</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div></div>
@endsection
