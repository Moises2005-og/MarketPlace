@extends('layouts.guest')

@section('title', 'Registo de Vendedor')

@section('content')
<div class="login-wrapper">
    <div class="login-form-panel w-100">
        <div class="login-form-inner mx-auto" style="max-width: 480px;">
            <div class="mb-4">
                <h2 class="h3 fw-bold mb-1">Tornar-se Vendedor</h2>
                <p class="text-muted mb-0">Preencha os dados para solicitar acesso à plataforma</p>
            </div>

            <form action="{{ route('seller.register') }}" method="POST" class="login-form">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nome completo *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required autofocus>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email *</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Telefone *</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone') }}" placeholder="+351 900 000 000" required>
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Senha *</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    <div class="form-text">Mínimo 8 caracteres, com letras maiúsculas, minúsculas e números.</div>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Confirmar senha *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-person-plus me-2"></i>Solicitar Registo
                </button>
            </form>

            <p class="text-center mt-4 mb-0 small">
                Já tem conta? <a href="{{ route('login') }}">Entrar</a>
            </p>
        </div>
    </div>
</div>
@endsection
