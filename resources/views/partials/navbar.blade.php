<header class="site-header">
    <a href="/" class="logo">Warisan Malaysia: Cultural Heritage & Events</a>

    <nav class="navbar">
        <a href="/">Home</a>
        <a href="{{ route('events.index') }}">Events</a>
        <a href="{{ route('contact') }}">Contact Us</a>

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.events.index') }}">Manage Events</a>
            @else
                <a href="{{ route('user.registrations.index') }}">My Registrations</a>
            @endif

            <span class="welcome">Welcome, {{ auth()->user()->name }}!</span>

            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        @else
            <a href="/login">Login</a>
            <a href="/register" class="register-link">Register</a>
        @endauth
    </nav>
</header>
