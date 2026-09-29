<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fan Hub Plus') — Fan Hub Plus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body style="background:var(--bg-main);color:var(--text-main);min-height:100vh;">

    

    <main style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem 1rem;">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
