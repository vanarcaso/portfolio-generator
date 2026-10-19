<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Portfolio Generator</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-page">

    <header class="auth-header">
        <nav class="auth-nav">
            <a href="{{ route('home') }}" class="auth-brand">
                Portfolio Generator
            </a>

            <div class="auth-nav-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('login') }}" class="active">Log In</a>
                <a href="{{ route('register') }}">Register</a>
            </div>
        </nav>
    </header>

    <main class="auth-main">
        <section class="auth-card">
            <h1 class="auth-heading">Welcome Back</h1>
            <p class="auth-description">
                Log in to manage your portfolio.
            </p>

            @if ($errors->any())
                <div class="auth-alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST">
                @csrf

                <div class="auth-field">
                    <label for="email" class="auth-label">
                        Email Address
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="auth-input"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="auth-field">
                    <label for="password" class="auth-label">
                        Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="auth-input"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button type="submit" class="auth-button">
                    Log In
                </button>
            </form>

            <p class="auth-footer">
                Don't have an account?
                <a href="{{ route('register') }}">Register here</a>
            </p>
        </section>
    </main>

</body>
</html>