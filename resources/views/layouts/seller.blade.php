<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vendedor') — Marketplace</title>
    @include('partials.head-assets')
</head>
<body>
    <nav class="navbar navbar-dark admin-topbar">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('seller.dashboard') }}">
                <img src="{{ asset('favicon.svg') }}" alt="" width="28" height="28">
                <span><i class="bi bi-bag me-1"></i>Painel Vendedor</span>
            </a>
            <div class="d-flex gap-2 align-items-center">
                <span class="text-white small d-none d-md-inline opacity-75">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">@csrf<button class="btn btn-sm btn-outline-light"><i class="bi bi-box-arrow-right me-1"></i>Sair</button></form>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 admin-sidebar p-3">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}" href="{{ route('seller.dashboard') }}"><i class="bi bi-grid me-2"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('seller.products.*') ? 'active' : '' }}" href="{{ route('seller.products.index') }}"><i class="bi bi-box me-2"></i>Meus Produtos</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('seller.orders.*') ? 'active' : '' }}" href="{{ route('seller.orders.index') }}"><i class="bi bi-receipt me-2"></i>Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('seller.sales.*') ? 'active' : '' }}" href="{{ route('seller.sales.index') }}"><i class="bi bi-graph-up me-2"></i>Vendas</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Perfil</a></li>
                </ul>
            </nav>
            <main class="col-md-9 col-lg-10 p-4">
                @include('partials.alerts')
                @yield('content')
            </main>
        </div>
    </div>
    @include('partials.scripts')
</body>
</html>
