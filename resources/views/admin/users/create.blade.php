@extends('layouts.admin')

@section('title', 'Novo Utilizador')

@section('content')
<h1 class="h3 mb-4">Novo Utilizador</h1>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            @include('admin.users._form')
            <button type="submit" class="btn btn-primary">Criar</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
