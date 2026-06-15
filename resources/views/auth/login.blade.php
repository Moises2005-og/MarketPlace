@extends('layouts.guest')

@section('title', 'Entrar')

@section('content')
<div class="login-wrapper">
    <div class="login-visual d-none d-lg-flex">
        <div class="login-visual-mosaic" aria-hidden="true">
            <div class="mosaic-item mosaic-1"><img src="https://images.unsplash.com/photo-1498049794561-7780e7231661?w=400&h=300&fit=crop" alt=""></div>
            <div class="mosaic-item mosaic-2"><img src="https://images.unsplash.com/photo-1445205170230-053b83016050?w=400&h=300&fit=crop" alt=""></div>
            <div class="mosaic-item mosaic-3"><img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=400&h=300&fit=crop" alt=""></div>
            <div class="mosaic-item mosaic-4"><img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400&h=300&fit=crop" alt=""></div>
            <div class="mosaic-item mosaic-5"><img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=400&h=300&fit=crop" alt=""></div>
            <div class="mosaic-item mosaic-6"><img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&h=300&fit=crop" alt=""></div>
        </div>
        <div class="login-visual-overlay"></div>
        <div class="login-visual-content">
            <div class="login-brand mb-4">
                <img src="{{ asset('favicon.svg') }}" alt="" width="52" height="52" class="login-logo mb-3">
                <h1 class="display-5 fw-bold text-white mb-3 lh-sm">
                    Venda mais.<br>Gerencie melhor.
                </h1>
                <p class="lead text-white opacity-90 mb-0">
                    A plataforma que liga vendedores e clientes num só lugar — simples, rápida e profissional.
                </p>
            </div>
            <div class="login-stats row g-3">
                <div class="col-4">
                    <div class="login-stat-card">
                        <div class="login-stat-value">8+</div>
                        <div class="login-stat-label">Categorias</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="login-stat-card">
                        <div class="login-stat-value"><i class="bi bi-shield-check"></i></div>
                        <div class="login-stat-label">Seguro</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="login-stat-card">
                        <div class="login-stat-value">24/7</div>
                        <div class="login-stat-label">Disponível</div>
                    </div>
                </div>
            </div>
            <div class="login-trust mt-4">
                <div class="d-flex align-items-center gap-2 text-white opacity-90">
                    <i class="bi bi-check-circle-fill"></i>
                    <span class="small">Gestão de produtos, stock e pedidos em tempo real</span>
                </div>
                <div class="d-flex align-items-center gap-2 text-white opacity-90 mt-2">
                    <i class="bi bi-check-circle-fill"></i>
                    <span class="small">Painel dedicado para administradores e vendedores</span>
                </div>
            </div>
        </div>
    </div>

    <div class="login-form-panel">
        <div class="login-form-inner">
            <div class="text-center d-lg-none mb-4">
                <img src="{{ asset('favicon.svg') }}" alt="" width="48" height="48" class="mb-2">
                <h1 class="h4 fw-bold text-primary mb-0">Marketplace</h1>
            </div>

            <div class="mb-4">
                <h2 class="h3 fw-bold mb-1">Bem-vindo</h2>
                <p class="text-muted mb-0">Introduza as suas credenciais para aceder</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="login-form">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-envelope text-primary"></i></span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="seu@email.com" required autofocus>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Senha</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-lock text-primary"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Lembrar-me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="small text-decoration-none">Esqueceu a senha?</a>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 login-btn">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                </button>
            </form>

            <p class="text-center mt-4 mb-0 small text-muted">
                Quer vender na plataforma?
                <a href="{{ route('seller.register') }}" class="text-decoration-none fw-semibold">Registar como vendedor</a>
            </p>
        </div>
    </div>
</div>
@endsection
