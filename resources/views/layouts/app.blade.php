
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Warisan Malaysia')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>

<body>

    {{-- Homepage hero before navbar --}}
    @yield('before-navbar')

    {{-- Shared navbar --}}
    @include('partials.navbar')

    {{-- Individual page content --}}
    <main>
        @yield('content')
    </main>

    {{-- Shared footer --}}
    @include('partials.footer')

    @stack('scripts')

</body>
</html>
