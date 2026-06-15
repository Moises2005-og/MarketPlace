@extends('layouts.admin')

@section('title', 'Nova Categoria')

@section('content')
<h1 class="h3 mb-4">Nova Categoria</h1>
<div class="card shadow-sm"><div class="card-body">
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.categories._form')
        <button type="submit" class="btn btn-primary">Criar</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div></div>
@endsection
