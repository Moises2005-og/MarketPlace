<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Marketplace') — {{ config('app.name', 'Marketplace') }}</title>
    @include('partials.head-assets')
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-marketplace sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <img src="{{ asset('favicon.svg') }}" alt="" width="28" height="28">
                Marketplace
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <form class="d-flex mx-lg-4 my-2 my-lg-0 flex-grow-1 search-form" action="{{ route('search') }}" method="GET">
                    <input class="form-control" type="search" name="q" placeholder="Pesquisar produtos..." value="{{ request('q') }}">
                    <button class="btn btn-search" type="submit"><i class="bi bi-search"></i></button>
                </form>
                <ul class="navbar-nav align-items-lg-center gap-1">
                    <li class="nav-item position-relative">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 fs-5"></i>
                            @if(($cartItemCount ?? 0) > 0)
                                <span class="badge bg-danger rounded-pill cart-badge">{{ $cartItemCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Admin</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}" alt="" class="rounded-circle" width="28" height="28">
                            <span class="d-none d-lg-inline">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-box-seam me-2"></i>Pedidos</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Sair</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @include('partials.alerts')
            @yield('content')
        </div>
    </main>

    <footer class="footer-marketplace">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="text-white mb-3"><i class="bi bi-shop me-2"></i>Marketplace</h5>
                    <p class="small">A sua loja online de confiança. Produtos de qualidade com entrega rápida.</p>
                </div>
                <div class="col-md-4">
                    <h6 class="text-white mb-3">Links Úteis</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('home') }}">Loja</a></li>
                        <li class="mb-2"><a href="{{ route('search') }}">Pesquisar</a></li>
                        <li class="mb-2"><a href="{{ route('admin.dashboard') }}">Painel Admin</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-white mb-3">Contacto</h6>
                    <p class="small mb-1"><i class="bi bi-envelope me-2"></i>suporte@marketplace.com</p>
                    <p class="small"><i class="bi bi-telephone me-2"></i>+351 800 000 000</p>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <p class="text-center small mb-0">&copy; {{ date('Y') }} Marketplace. Todos os direitos reservados.</p>
        </div>
    </footer>

    @include('partials.scripts')
    @stack('scripts')
</body>
</html>
