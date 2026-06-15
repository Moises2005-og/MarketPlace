@extends('layouts.admin')

@section('title', 'Editar Categoria')

@section('content')
<h1 class="h3 mb-4">Editar Categoria</h1>
<div class="card shadow-sm"><div class="card-body">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('admin.categories._form', ['category' => $category])
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div></div>
@endsection
