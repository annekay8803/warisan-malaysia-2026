
@extends('layouts.app')

@section('title', 'Login | Warisan Malaysia')

@push('styles')
<style>
    .auth-container {
        max-width: 450px;
        margin: 60px auto;
        padding: 0 25px;
    }

    .auth-card {
        background: white;
        padding: 35px;
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
    }

    .auth-card h1 {
        color: #6b3f2a;
        margin-bottom: 8px;
    }

    .auth-card p {
        color: #666;
    }

    .auth-card label {
        display: block;
        margin-top: 20px;
        margin-bottom: 7px;
        font-weight: bold;
        font-size: 14px;
    }

    .auth-card input {
        width: 100%;
        box-sizing: border-box;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    .auth-card input:focus {
        outline: none;
        border-color: #6b3f2a;
    }

    .login-btn {
        width: 100%;
        margin-top: 25px;
        padding: 12px;
        background: #6b3f2a;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 15px;
    }

    .login-btn:hover {
        background: #52301f;
    }

    .auth-link {
        text-align: center;
        margin-top: 22px;
        font-size: 14px;
    }

    .auth-link a,
    .back-link {
        color: #6b3f2a;
        text-decoration: none;
        font-weight: bold;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 20px;
    }

    .success-message {
        background: #dff0d8;
        color: #3c763d;
        padding: 12px;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .error-message {
        background: #f2dede;
        color: #a94442;
        padding: 12px;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 14px;
    }
</style>
@endpush

@section('content')

<div class="auth-container">

    <a href="{{ url('/') }}" class="back-link">
        ← Back to Home
    </a>

    <div class="auth-card">

        <h1>Welcome Back</h1>
        <p>Login to your Warisan Malaysia account.</p>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error-message">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter your email"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            >

            <button type="submit" class="login-btn">
                Login
            </button>

        </form>

        <div class="auth-link">
            Don't have an account?
            <a href="{{ url('/register') }}">Register</a>
        </div>

    </div>

</div>

@endsection
