<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/product.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
       <div class="layout-container">
            @include('layouts.navigation')

            <div class="content-area">
                <!-- Page Heading -->
                @isset($header)
                    <header class="page-header">
                        <div class="header-inner">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="page-content">
                    {{ $slot }}
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
        <script src="{{ asset('JS/Admin/Product/product.js') }}"></script>
        <script src="{{ asset('JS/Admin/Product/delete.js') }}"></script>
        <script src="{{ asset('JS/Admin/Product/view.js') }}"></script>
        <script src="{{ asset('JS/Admin/Product/edit.js') }}"></script>
    </body>
</html>
