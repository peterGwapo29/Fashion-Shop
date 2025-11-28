<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cart')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/wishlist.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">

    @stack('styles')
</head>
<body>
    <div class="container">
        <a href="{{ route('welcome') }}" style="display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <img src="/images/logo.png" alt="Fashion Store Logo" class="logo" style="width: 150px; height: auto;">
        </a>
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
