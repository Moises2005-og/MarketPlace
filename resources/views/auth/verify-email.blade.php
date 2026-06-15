@extends('layouts.app')

@section('title', 'Verificar Email')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm text-center">
            <div class="card-body p-5">
                <i class="bi bi-envelope-check display-1 text-primary mb-3"></i>
                <h1 class="h4 mb-3">Verifique o seu Email</h1>
                <p class="text-muted mb-4">Enviámos um link de verificação para <strong>{{ auth()->user()->email }}</strong>. Por favor, verifique a sua caixa de entrada.</p>
                <form action="{{ route('verification.send') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Reenviar Email de Verificação</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
