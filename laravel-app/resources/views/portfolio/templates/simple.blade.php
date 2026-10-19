
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $portfolio->full_name }} | Portfolio</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f8fafc;
            color: #0f172a;
            line-height: 1.6;
        }

        .simple-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 18px 6%;
            background: #0f172a;
            color: white;
        }

        .simple-brand {
            color: white;
            font-size: 20px;
            font-weight: 700;
            text-decoration: none;
        }

        .simple-nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .simple-nav-links a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .simple-nav-links a:hover {
            color: #93c5fd;
        }

        .simple-container {
            max-width: 1000px;
            margin: 36px auto;
            padding: 0 18px;
        }

        .simple-card {
            padding: 40px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 8px 28px rgba(15, 23, 42, 0.05);
        }

        .simple-hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 28px;
            padding-bottom: 28px;
            border-bottom: 1px solid #e2e8f0;
        }

        .simple-hero h1 {
            margin: 0 0 8px;
            font-size: clamp(28px, 4vw, 42px);
            line-height: 1.2;
            overflow-wrap: anywhere;
        }

        .simple-subtitle {
            margin: 0;
            color: #475569;
        }

        .simple-avatar {
            width: 130px;
            height: 130px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            object-fit: cover;
            background: #dbeafe;
            color: #2563eb;
            font-size: 36px;
            font-weight: 700;
        }

        .simple-section {
            padding: 26px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .simple-section:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .simple-section h2 {
            margin: 0 0 18px;
            font-size: 22px;
        }

        .simple-section p {
            margin: 7px 0;
            overflow-wrap: anywhere;
        }

        .simple-columns {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 30px;
        }

        .simple-item {
            margin-bottom: 18px;
        }

        .simple-item:last-child {
            margin-bottom: 0;
        }

        .simple-item h3 {
            margin: 0 0 5px;
            font-size: 17px;
        }

        .simple-muted {
            color: #64748b;
            font-size: 14px;
        }

        .simple-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
        }

        .simple-skill {
            padding: 6px 12px;
            border-radius: 20px;
            background: #dbeafe;
            color: #1e40af;
            font-size: 14px;
        }

        .simple-link {
            color: #2563eb;
            text-decoration: none;
            overflow-wrap: anywhere;
        }

        .simple-link:hover {
            text-decoration: underline;
        }

        .simple-socials {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
        }

        .simple-footer {
            padding: 24px 10px;
            text-align: center;
            color: #64748b;
            font-size: 13px;
        }

        @media (max-width: 650px) {
            .simple-nav {
                align-items: flex-start;
                flex-direction: column;
            }

            .simple-card {
                padding: 24px 20px;
            }

            .simple-hero {
                align-items: flex-start;
                flex-direction: column-reverse;
            }

            .simple-avatar {
                width: 100px;
                height: 100px;
                font-size: 28px;
            }

            .simple-columns {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>

<body>

<header class="simple-nav">
    <a href="{{ route('home') }}" class="simple-brand">
        Portfolio
    </a>

    <nav class="simple-nav-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('portfolio.manage') }}">Manage Portfolio</a>
        <a href="{{ route('portfolio.edit') }}">Edit Information</a>
    </nav>
</header>

<main class="simple-container">
    <article class="simple-card">

        <section class="simple-hero">
            <div>
                <h1>{{ $portfolio->full_name }}</h1>

                @if ($portfolio->experiences->isNotEmpty())
                    <p class="simple-subtitle">
                        {{ $portfolio->experiences->first()->position }}
                        @if ($portfolio->experiences->first()->organization)
                            · {{ $portfolio->experiences->first()->organization }}
                        @endif
                    </p>
                @endif

                @if ($portfolio->email)
                    <p class="simple-muted">{{ $portfolio->email }}</p>
                @endif
            </div>

            @if ($portfolio->profile_picture_path)
                <img
                    src="{{ asset('storage/' . $portfolio->profile_picture_path) }}"
                    alt="{{ $portfolio->full_name }}"
                    class="simple-avatar"
                >
            @else
                <div class="simple-avatar" aria-label="Profile initials">
                    {{ collect(explode(' ', trim($portfolio->full_name)))->filter()->take(2)->map(fn ($name) => strtoupper(substr($name, 0, 1)))->implode('') }}
                </div>
            @endif
        </section>

        @if ($portfolio->about_me)
            <section class="simple-section">
                <h2>About Me</h2>
                <p>{{ $portfolio->about_me }}</p>
            </section>
        @endif

        <div class="simple-section simple-columns">

            @if ($portfolio->education->isNotEmpty())
                <section>
                    <h2>Education</h2>

                    @foreach ($portfolio->education as $item)
                        <div class="simple-item">
                            @if ($item->school)
                                <h3>{{ $item->school }}</h3>
                            @endif

                            @if ($item->course_program)
                                <p>{{ $item->course_program }}</p>
                            @endif

                            @if ($item->year)
                                <p class="simple-muted">{{ $item->year }}</p>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            @if ($portfolio->skills->isNotEmpty())
                <section>
                    <h2>Skills</h2>

                    <div class="simple-skills">
                        @foreach ($portfolio->skills as $item)
                            <span class="simple-skill">
                                {{ $item->skill_name }}
                            </span>
                        @endforeach
                    </div>
                </section>
            @endif

        </div>

        @if ($portfolio->projects->isNotEmpty())
            <section class="simple-section">
                <h2>Projects</h2>

                @foreach ($portfolio->projects as $item)
                    <div class="simple-item">
                        @if ($item->title)
                            <h3>{{ $item->title }}</h3>
                        @endif

                        @if ($item->description)
                            <p>{{ $item->description }}</p>
                        @endif

                        @if ($item->link)
                            <a class="simple-link"
                               href="{{ $item->link }}"
                               target="_blank"
                               rel="noopener noreferrer">
                                View Project
                            </a>
                        @endif
                    </div>
                @endforeach
            </section>
        @endif

        @if ($portfolio->experiences->isNotEmpty())
            <section class="simple-section">
                <h2>Work Experience</h2>

                @foreach ($portfolio->experiences as $item)
                    <div class="simple-item">
                        @if ($item->position)
                            <h3>{{ $item->position }}</h3>
                        @endif

                        @if ($item->organization)
                            <p>{{ $item->organization }}</p>
                        @endif

                        @if ($item->description)
                            <p>{{ $item->description }}</p>
                        @endif
                    </div>
                @endforeach
            </section>
        @endif

        @if ($portfolio->contact_number || $portfolio->address)
            <section class="simple-section">
                <h2>Contact</h2>

                @if ($portfolio->contact_number)
                    <p>{{ $portfolio->contact_number }}</p>
                @endif

                @if ($portfolio->address)
                    <p>{{ $portfolio->address }}</p>
                @endif
            </section>
        @endif

        @if ($portfolio->website_url || $portfolio->facebook_url || $portfolio->linkedin_url || $portfolio->github_url)
            <section class="simple-section">
                <h2>Links</h2>

                <div class="simple-socials">
                    @if ($portfolio->website_url)
                        <a class="simple-link" href="{{ $portfolio->website_url }}" target="_blank" rel="noopener noreferrer">Website</a>
                    @endif

                    @if ($portfolio->facebook_url)
                        <a class="simple-link" href="{{ $portfolio->facebook_url }}" target="_blank" rel="noopener noreferrer">Facebook</a>
                    @endif

                    @if ($portfolio->linkedin_url)
                        <a class="simple-link" href="{{ $portfolio->linkedin_url }}" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                    @endif

                    @if ($portfolio->github_url)
                        <a class="simple-link" href="{{ $portfolio->github_url }}" target="_blank" rel="noopener noreferrer">GitHub</a>
                    @endif
                </div>
            </section>
        @endif

    </article>

    <footer class="simple-footer">
        Portfolio created with Portfolio Generator
    </footer>
</main>

</body>
</html>
