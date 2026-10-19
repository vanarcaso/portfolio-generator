<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Portfolio Template Generator</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<header class="site-header">
    <div class="container nav">

        <span class="logo">Portfolio Generator</span>

        <nav>
            <a href="{{ url('/') }}">Home</a>

            @auth
                <a href="{{ route('portfolio.manage') }}">Manage Portfolio</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn outline">
                        Log Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}">Log In</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </nav>

    </div>
</header>

<main>
    <section class="hero">
        <div class="container hero-grid">

            <div class="hero-content">

                <h1>
                    Build your portfolio.
                    <span>Choose your style.</span>
                </h1>

                <p>
                    Enter your information, choose a template,
                    and generate your professional online portfolio.
                </p>

                <div class="actions">
                    @auth
                        <a href="{{ url('/portfolio/create') }}" class="btn">
                            Create Portfolio
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn">
                            Create Portfolio
                        </a>
                    @endauth
                </div>

            </div>

            <div class="how-card">

                <p class="label">HOW IT WORKS</p>

                <h2>Create your portfolio in three steps</h2>

                <div class="how-step">
                    <div class="step-number">01</div>
                    <div>
                        <h3>Enter Information</h3>
                        <p>Add your profile, education, skills and projects.</p>
                    </div>
                </div>

                <div class="how-step">
                    <div class="step-number">02</div>
                    <div>
                        <h3>Choose Template</h3>
                        <p>Select Simple, Modern or Creative.</p>
                    </div>
                </div>

                <div class="how-step">
                    <div class="step-number">03</div>
                    <div>
                        <h3>Generate Portfolio</h3>
                        <p>Preview, edit or change your template anytime.</p>
                    </div>
                </div>

            </div>

        </div>
    </section>
</main>

</body>
</html>