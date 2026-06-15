<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Entrar') — {{ config('app.name', 'Marketplace') }}</title>
    @include('partials.head-assets')
    @stack('styles')
</head>
<body class="login-page">
    @yield('content')
    @include('partials.scripts')
    @stack('scripts')
</body>
</html>
