
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio | Portfolio Generator</title>
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

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        style="padding: 10px 16px; border-radius: 7px;
                        border: 1px solid #2563eb; background: white;
                        color: #2563eb; cursor: pointer;">
                    Log Out
                </button>
            </form>
        </div>
    </nav>
</header>

<main class="portfolio-main">
    <section class="portfolio-card">

        @if (session('success'))
            <div style="padding: 12px; margin-bottom: 20px;
                        background: #dcfce7; color: #166534;
                        border-radius: 8px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="auth-alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($portfolio)

            <h1 class="portfolio-title">My Portfolio</h1>

            <p class="portfolio-description">
                Your portfolio has been saved to your account.
            </p>

            @if ($portfolio->profile_picture_path)
                <img
                    src="{{ asset('storage/' . $portfolio->profile_picture_path) }}"
                    alt="Profile picture"
                    style="width: 120px; height: 120px;
                    object-fit: cover; border-radius: 50%;
                    margin-bottom: 20px;"
                >
            @endif

            <section class="portfolio-section">
                <h2 class="portfolio-section-title">
                    Personal Information
                </h2>

                <p><strong>Full Name:</strong>
                    {{ $portfolio->full_name }}
                </p>

                <p><strong>Email:</strong>
                    {{ $portfolio->email }}
                </p>

                <p><strong>Contact Number:</strong>
                    {{ $portfolio->contact_number ?: 'Not provided' }}
                </p>

                <p><strong>Address:</strong>
                    {{ $portfolio->address ?: 'Not provided' }}
                </p>

                <p><strong>About Me:</strong>
                    {{ $portfolio->about_me ?: 'Not provided' }}
                </p>

                <p><strong>Selected Template:</strong>
                    {{ ucfirst($portfolio->selected_template) }}
                </p>
            </section>

            <section class="portfolio-section">
                <h2 class="portfolio-section-title">Education</h2>

                @forelse ($portfolio->education as $item)
                    <div class="repeat-row">
                        <p><strong>{{ $item->school }}</strong></p>
                        <p>{{ $item->course_program }}</p>
                        <p>{{ $item->year }}</p>
                    </div>
                @empty
                    <p>No education entries added.</p>
                @endforelse
            </section>

            <section class="portfolio-section">
                <h2 class="portfolio-section-title">Skills</h2>

                @forelse ($portfolio->skills as $item)
                    <p>{{ $item->skill_name }}</p>
                @empty
                    <p>No skills added.</p>
                @endforelse
            </section>

            <section class="portfolio-section">
                <h2 class="portfolio-section-title">Projects</h2>

                @forelse ($portfolio->projects as $item)
                    <div class="repeat-row">
                        <p><strong>{{ $item->title }}</strong></p>
                        <p>{{ $item->description }}</p>

                        @if ($item->link)
                            <a href="{{ $item->link }}"
                               target="_blank"
                               rel="noopener noreferrer">
                                View Project
                            </a>
                        @endif
                    </div>
                @empty
                    <p>No projects added.</p>
                @endforelse
            </section>

            <section class="portfolio-section">
                <h2 class="portfolio-section-title">
                    Work Experience
                </h2>

                @forelse ($portfolio->experiences as $item)
                    <div class="repeat-row">
                        <p><strong>{{ $item->position }}</strong></p>
                        <p>{{ $item->organization }}</p>
                        <p>{{ $item->description }}</p>
                    </div>
                @empty
                    <p>No work experience added.</p>
                @endforelse
            </section>

        @else

            <h1 class="portfolio-title">Welcome to Your Workspace!</h1>

            <p class="portfolio-description">
                You haven't created a portfolio yet. Start by entering
                your information and choosing a template.
            </p>

            <a href="{{ route('portfolio.create') }}"
               class="portfolio-submit"
               style="display: block; text-align: center;
                      text-decoration: none;">
                Create Portfolio
            </a>

        @endif

    </section>
</main>

</body>
</html>
