<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Marketplace</title>
    @include('partials.head-assets')
</head>
<body>
    <nav class="navbar navbar-dark admin-topbar">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('favicon.svg') }}" alt="" width="28" height="28">
                <span><i class="bi bi-speedometer2 me-1"></i>Painel Admin</span>
            </a>
            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('home') }}" class="btn btn-sm btn-light"><i class="bi bi-shop me-1"></i>Loja</a>
                <span class="text-white small d-none d-md-inline opacity-75">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">@csrf<button class="btn btn-sm btn-outline-light"><i class="bi bi-box-arrow-right"></i></button></form>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 admin-sidebar p-3">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid me-2"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.sellers.*') ? 'active' : '' }}" href="{{ route('admin.sellers.index') }}"><i class="bi bi-shop me-2"></i>Vendedores</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people me-2"></i>Utilizadores</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><i class="bi bi-tags me-2"></i>Categorias</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="bi bi-box me-2"></i>Produtos</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}"><i class="bi bi-receipt me-2"></i>Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li class="nav-item mt-3"><a class="nav-link" href="{{ route('home') }}"><i class="bi bi-shop me-2"></i>Ver Loja</a></li>
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
