<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $store->description }}">
    <meta name="keywords" content="{{ $store->meta_keywords }}">
    <meta name="author" content="{{ $store->name }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('storage/' . $store->favicon) }}">
    <link rel="shortcut icon" href="{{ asset('storage/' . $store->favicon) }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/' . $store->favicon) }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('storage/' . $store->favicon) }}">
    <link rel="manifest" href="{{ asset('storage/' . $store->favicon) }}">



    {{-- Tus estilos propios --}}
    @include('components.layouts.home.styles')
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">

    {{-- HEADER --}}
    @include('components.layouts.home.header')

    {{-- CONTENIDO --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('components.layouts.home.footer')

    {{-- Scripts --}}
    @include('components.layouts.home.scripts')

</body>
</html>
