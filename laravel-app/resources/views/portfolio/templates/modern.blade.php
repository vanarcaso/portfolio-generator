
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $portfolio->full_name }} | Modern Portfolio</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #eef2f7;
            color: #172033;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
        }

        .modern-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 18px 6%;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }

        .modern-brand {
            color: #172033;
            font-size: 20px;
            font-weight: 800;
            text-decoration: none;
        }

        .modern-nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .modern-nav-links a {
            color: #475569;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
        }

        .modern-nav-links a:hover {
            color: #2563eb;
        }

        .modern-hero {
            padding: 56px 20px;
            background: linear-gradient(135deg, #1d4ed8, #2563eb 55%, #38bdf8);
            color: #ffffff;
        }

        .modern-hero-inner {
            max-width: 1080px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .modern-avatar {
            width: 140px;
            height: 140px;
            flex-shrink: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 4px solid rgba(255,255,255,0.75);
            border-radius: 24px;
            background: rgba(255,255,255,0.2);
            color: #ffffff;
            object-fit: cover;
            font-size: 36px;
            font-weight: 800;
        }

        .modern-hero h1 {
            margin: 0 0 10px;
            font-size: clamp(30px, 5vw, 46px);
            line-height: 1.2;
            overflow-wrap: anywhere;
        }

        .modern-hero p {
            margin: 6px 0;
            color: #eff6ff;
            overflow-wrap: anywhere;
        }

        .modern-container {
            display: grid;
            grid-template-columns: minmax(0, 0.85fr) minmax(0, 1.65fr);
            gap: 24px;
            max-width: 1080px;
            margin: 32px auto;
            padding: 0 20px;
            align-items: start;
        }

        .modern-column {
            display: grid;
            gap: 24px;
            min-width: 0;
        }

        .modern-card {
            min-width: 0;
            padding: 26px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
        }

        .modern-card h2 {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 20px;
            color: #1d4ed8;
            font-size: 20px;
        }

        .modern-card h3 {
            margin: 0 0 5px;
            font-size: 16px;
            color: #172033;
        }

        .modern-card p {
            margin: 7px 0;
            overflow-wrap: anywhere;
        }

        .modern-muted {
            color: #64748b;
            font-size: 14px;
        }

        .modern-item {
            padding: 0 0 18px;
            margin: 0 0 18px;
            border-bottom: 1px solid #e2e8f0;
        }

        .modern-item:last-child {
            padding-bottom: 0;
            margin-bottom: 0;
            border-bottom: none;
        }

        .modern-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
        }

        .modern-skill {
            padding: 7px 12px;
            border-radius: 8px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 13px;
            font-weight: 600;
        }

        .modern-links {
            display: grid;
            gap: 10px;
        }

        .modern-links a,
        .modern-project-link {
            color: #2563eb;
            font-weight: 600;
            font-size: 14px;
            overflow-wrap: anywhere;
            text-decoration: none;
        }

        .modern-links a:hover,
        .modern-project-link:hover {
            text-decoration: underline;
        }

        .modern-footer {
            padding: 26px 15px;
            color: #64748b;
            text-align: center;
            font-size: 13px;
        }

        @media (max-width: 760px) {
            .modern-nav {
                align-items: flex-start;
                flex-direction: column;
            }

            .modern-hero-inner {
                align-items: flex-start;
                flex-direction: column;
            }

            .modern-avatar {
                width: 110px;
                height: 110px;
                border-radius: 18px;
            }

            .modern-container {
                grid-template-columns: 1fr;
                margin-top: 20px;
                gap: 18px;
            }

            .modern-card {
                padding: 22px;
            }
        }
    </style>
</head>

<body>

<header class="modern-nav">
    <a href="{{ route('home') }}" class="modern-brand">MY PORTFOLIO</a>

    <nav class="modern-nav-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('portfolio.manage') }}">Manage Portfolio</a>
        <a href="{{ route('portfolio.edit') }}">Edit Information</a>
    </nav>
</header>

<section class="modern-hero">
    <div class="modern-hero-inner">

        @if ($portfolio->profile_picture_path)
            <img
                src="{{ asset('storage/' . $portfolio->profile_picture_path) }}"
                alt="{{ $portfolio->full_name }}"
                class="modern-avatar"
            >
        @else
            <div class="modern-avatar">
                {{ collect(explode(' ', trim($portfolio->full_name)))->filter()->take(2)->map(fn ($name) => strtoupper(substr($name, 0, 1)))->implode('') }}
            </div>
        @endif

        <div>
            <h1>{{ $portfolio->full_name }}</h1>

            @if ($portfolio->experiences->isNotEmpty())
                <p>
                    {{ $portfolio->experiences->first()->position }}
                    @if ($portfolio->experiences->first()->organization)
                        · {{ $portfolio->experiences->first()->organization }}
                    @endif
                </p>
            @endif

            @if ($portfolio->email)
                <p>{{ $portfolio->email }}</p>
            @endif
        </div>
    </div>
</section>

<main class="modern-container">

    <!-- Left column -->
    <div class="modern-column">

        @if ($portfolio->about_me)
            <section class="modern-card">
                <h2>About Me</h2>
                <p>{{ $portfolio->about_me }}</p>
            </section>
        @endif

        @if ($portfolio->skills->isNotEmpty())
            <section class="modern-card">
                <h2>Skills</h2>

                <div class="modern-skills">
                    @foreach ($portfolio->skills as $item)
                        <span class="modern-skill">{{ $item->skill_name }}</span>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="modern-card">
            <h2>Contact</h2>

            @if ($portfolio->email)
                <p>{{ $portfolio->email }}</p>
            @endif

            @if ($portfolio->contact_number)
                <p>{{ $portfolio->contact_number }}</p>
            @endif

            @if ($portfolio->address)
                <p>{{ $portfolio->address }}</p>
            @endif
        </section>

        @if ($portfolio->website_url || $portfolio->facebook_url || $portfolio->linkedin_url || $portfolio->github_url)
            <section class="modern-card">
                <h2>Find Me Online</h2>

                <div class="modern-links">
                    @if ($portfolio->website_url)
                        <a href="{{ $portfolio->website_url }}" target="_blank" rel="noopener noreferrer">Personal Website ↗</a>
                    @endif

                    @if ($portfolio->facebook_url)
                        <a href="{{ $portfolio->facebook_url }}" target="_blank" rel="noopener noreferrer">Facebook ↗</a>
                    @endif

                    @if ($portfolio->linkedin_url)
                        <a href="{{ $portfolio->linkedin_url }}" target="_blank" rel="noopener noreferrer">LinkedIn ↗</a>
                    @endif

                    @if ($portfolio->github_url)
                        <a href="{{ $portfolio->github_url }}" target="_blank" rel="noopener noreferrer">GitHub ↗</a>
                    @endif
                </div>
            </section>
        @endif

    </div>

    <!-- Right column -->
    <div class="modern-column">

        @if ($portfolio->education->isNotEmpty())
            <section class="modern-card">
                <h2>Education</h2>

                @foreach ($portfolio->education as $item)
                    <div class="modern-item">
                        @if ($item->school)
                            <h3>{{ $item->school }}</h3>
                        @endif

                        @if ($item->course_program)
                            <p>{{ $item->course_program }}</p>
                        @endif

                        @if ($item->year)
                            <p class="modern-muted">{{ $item->year }}</p>
                        @endif
                    </div>
                @endforeach
            </section>
        @endif

        @if ($portfolio->projects->isNotEmpty())
            <section class="modern-card">
                <h2>Featured Projects</h2>

                @foreach ($portfolio->projects as $item)
                    <div class="modern-item">
                        @if ($item->title)
                            <h3>{{ $item->title }}</h3>
                        @endif

                        @if ($item->description)
                            <p>{{ $item->description }}</p>
                        @endif

                        @if ($item->link)
                            <a class="modern-project-link"
                               href="{{ $item->link }}"
                               target="_blank"
                               rel="noopener noreferrer">
                                View Project ↗
                            </a>
                        @endif
                    </div>
                @endforeach
            </section>
        @endif

        @if ($portfolio->experiences->isNotEmpty())
            <section class="modern-card">
                <h2>Experience</h2>

                @foreach ($portfolio->experiences as $item)
                    <div class="modern-item">
                        @if ($item->position)
                            <h3>{{ $item->position }}</h3>
                        @endif

                        @if ($item->organization)
                            <p class="modern-muted">{{ $item->organization }}</p>
                        @endif

                        @if ($item->description)
                            <p>{{ $item->description }}</p>
                        @endif
                    </div>
                @endforeach
            </section>
        @endif

    </div>
</main>

<footer class="modern-footer">
    Portfolio created with Portfolio Generator
</footer>

</body>
</html>
