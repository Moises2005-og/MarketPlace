@extends('layouts.admin')

@section('title', 'Editar Utilizador')

@section('content')
<h1 class="h3 mb-4">Editar Utilizador</h1>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf @method('PUT')
            @include('admin.users._form', ['user' => $user])
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
