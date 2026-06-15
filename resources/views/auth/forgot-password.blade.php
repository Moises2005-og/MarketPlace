@extends('layouts.guest')

@section('title', 'Recuperar Senha')

@section('content')
<div class="login-wrapper">
    <div class="login-form-panel w-100" style="max-width:100%">
        <div class="login-form-inner mx-auto">
            <div class="text-center mb-4">
                <img src="{{ asset('favicon.svg') }}" alt="" width="48" height="48" class="mb-2">
                <h1 class="h4 fw-bold">Recuperar Senha</h1>
                <p class="text-muted">Introduza o seu email para receber o link de recuperação</p>
            </div>
            @include('partials.alerts')
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 login-btn mb-3">Enviar Link</button>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">Voltar ao login</a>
            </form>
        </div>
    </div>
</div>
@endsection
