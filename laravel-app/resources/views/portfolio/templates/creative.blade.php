
@php
    $palettes = [
        'ocean' => [
            'bg' => '#0B1220',
            'surface' => '#111827',
            'card' => '#172033',
            'accent' => '#38BDF8',
            'text' => '#F8FAFC',
            'muted' => '#CBD5E1',
            'accentText' => '#082F49',
        ],
        'sunset' => [
            'bg' => '#2B100B',
            'surface' => '#431407',
            'card' => '#571E0C',
            'accent' => '#FB923C',
            'text' => '#FFF7ED',
            'muted' => '#FED7AA',
            'accentText' => '#431407',
        ],
        'lavender' => [
            'bg' => '#190C32',
            'surface' => '#2E1065',
            'card' => '#3B1B67',
            'accent' => '#C4B5FD',
            'text' => '#FAF5FF',
            'muted' => '#E9D5FF',
            'accentText' => '#2E1065',
        ],
        'forest' => [
            'bg' => '#071B12',
            'surface' => '#052E16',
            'card' => '#14532D',
            'accent' => '#A3E635',
            'text' => '#F0FDF4',
            'muted' => '#BBF7D0',
            'accentText' => '#052E16',
        ],
        'monochrome' => [
            'bg' => '#09090B',
            'surface' => '#18181B',
            'card' => '#27272A',
            'accent' => '#F4F4F5',
            'text' => '#FAFAFA',
            'muted' => '#D4D4D8',
            'accentText' => '#18181B',
        ],
    ];

    $paletteKey = $portfolio->color_palette ?? 'ocean';
    $palette = $palettes[$paletteKey] ?? $palettes['ocean'];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $portfolio->full_name }} | Creative Portfolio</title>

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --creative-bg: {{ $palette['bg'] }};
            --creative-surface: {{ $palette['surface'] }};
            --creative-card: {{ $palette['card'] }};
            --creative-accent: {{ $palette['accent'] }};
            --creative-text: {{ $palette['text'] }};
            --creative-muted: {{ $palette['muted'] }};
            --creative-accent-text: {{ $palette['accentText'] }};
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: var(--creative-bg);
            color: var(--creative-text);
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.7;
        }

        a {
            color: var(--creative-accent);
        }

        .creative-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
            padding: 22px 6%;
            background: var(--creative-surface);
            border-bottom: 1px solid var(--creative-card);
        }

        .creative-brand {
            color: var(--creative-text);
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 2px;
            text-decoration: none;
        }

        .creative-nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .creative-nav-links a {
            color: var(--creative-muted);
            font-size: 14px;
            text-decoration: none;
        }

        .creative-nav-links a:hover {
            color: var(--creative-accent);
        }

        .creative-container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .creative-hero {
            position: relative;
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(180px, 0.6fr);
            align-items: center;
            gap: 50px;
            padding-top: 80px;
            padding-bottom: 90px;
        }

        .creative-kicker {
            display: inline-block;
            margin-bottom: 20px;
            padding: 7px 13px;
            border: 1px solid var(--creative-accent);
            border-radius: 30px;
            color: var(--creative-accent);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .creative-hero h1 {
            margin: 0;
            max-width: 700px;
            font-size: clamp(40px, 7vw, 76px);
            line-height: 1.05;
            letter-spacing: -2px;
            overflow-wrap: anywhere;
        }

        .creative-highlight {
            color: var(--creative-accent);
        }

        .creative-hero-description {
            max-width: 650px;
            margin-top: 24px;
            color: var(--creative-muted);
            font-size: 17px;
            overflow-wrap: anywhere;
        }

        .creative-profile-frame {
            position: relative;
            width: 100%;
            max-width: 270px;
            aspect-ratio: 4 / 5;
            justify-self: end;
            padding: 10px;
            border: 2px solid var(--creative-accent);
            border-radius: 140px 140px 24px 24px;
            background: var(--creative-card);
            box-shadow: 14px 14px 0 var(--creative-surface);
        }

        .creative-profile {
            display: flex;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
            border-radius: 130px 130px 16px 16px;
            background: var(--creative-surface);
            color: var(--creative-accent);
            object-fit: cover;
            font-size: 55px;
            font-weight: 800;
        }

        .creative-section {
            padding: 55px 0;
            border-top: 1px solid var(--creative-card);
            scroll-margin-top: 20px;
        }

        .creative-section-heading {
            display: flex;
            align-items: baseline;
            flex-wrap: wrap;
            gap: 12px;
            margin: 0 0 26px;
            font-size: clamp(26px, 4vw, 36px);
            line-height: 1.2;
        }

        .creative-section-number {
            color: var(--creative-accent);
            font-size: 14px;
            letter-spacing: 2px;
        }

        .creative-about {
            max-width: 850px;
            color: var(--creative-muted);
            font-size: 18px;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        .creative-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .creative-card {
            min-width: 0;
            padding: 25px;
            border: 1px solid var(--creative-card);
            border-radius: 14px;
            background: var(--creative-surface);
        }

        .creative-card h3 {
            margin: 0 0 8px;
            color: var(--creative-text);
            font-size: 19px;
            overflow-wrap: anywhere;
        }

        .creative-card p {
            margin: 8px 0;
            color: var(--creative-muted);
            overflow-wrap: anywhere;
        }

        .creative-card .creative-meta {
            color: var(--creative-accent);
            font-size: 13px;
            font-weight: 700;
        }

        .creative-skill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .creative-skill {
            padding: 10px 15px;
            border: 1px solid var(--creative-accent);
            border-radius: 8px 8px 8px 2px;
            background: var(--creative-card);
            color: var(--creative-text);
            font-size: 14px;
        }

        .creative-project-link {
            display: inline-block;
            margin-top: 10px;
            color: var(--creative-accent);
            font-weight: 700;
            text-decoration: none;
        }

        .creative-project-link:hover {
            text-decoration: underline;
        }

        .creative-contact {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .creative-contact-item {
            padding: 18px;
            border-left: 3px solid var(--creative-accent);
            background: var(--creative-surface);
            overflow-wrap: anywhere;
        }

        .creative-contact-label {
            display: block;
            margin-bottom: 5px;
            color: var(--creative-muted);
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .creative-contact-item a {
            overflow-wrap: anywhere;
            text-decoration: none;
        }

        .creative-footer {
            padding: 30px 20px;
            border-top: 1px solid var(--creative-card);
            color: var(--creative-muted);
            text-align: center;
            font-size: 13px;
        }

        @media (max-width: 720px) {
            .creative-hero {
                grid-template-columns: 1fr;
                gap: 35px;
                padding-top: 50px;
                padding-bottom: 55px;
            }

            .creative-profile-frame {
                width: 190px;
                justify-self: start;
            }

            .creative-grid,
            .creative-contact {
                grid-template-columns: 1fr;
            }

            .creative-section {
                padding: 38px 0;
            }

            .creative-container {
                padding: 0 18px;
            }

            .creative-hero h1 {
                letter-spacing: -1px;
            }
        }
    </style>
</head>

<body>

<header class="creative-nav">
    <a href="{{ route('home') }}" class="creative-brand">
        PORTFOLIO<span class="creative-highlight">.</span>
    </a>

    <nav class="creative-nav-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('portfolio.manage') }}">Manage Portfolio</a>
        <a href="{{ route('portfolio.edit') }}">Edit Information</a>
        <a href="#about">About</a>
        <a href="#skills">Skills</a>
        <a href="#projects">Projects</a>
        <a href="#contact">Contact</a>
    </nav>
</header>

<main id="top">

    <section class="creative-container creative-hero">

        <div>
            <span class="creative-kicker">Creative Portfolio</span>

            <h1>
                Hello, I'm
                <span class="creative-highlight">
                    {{ $portfolio->full_name }}
                </span>
            </h1>

            @if ($portfolio->experiences->isNotEmpty() &&
                 $portfolio->experiences->first()->position)
                <p class="creative-hero-description">
                    {{ $portfolio->experiences->first()->position }}
                    @if ($portfolio->experiences->first()->organization)
                        · {{ $portfolio->experiences->first()->organization }}
                    @endif
                </p>
            @elseif ($portfolio->about_me)
                <p class="creative-hero-description">
                    {{ $portfolio->about_me }}
                </p>
            @endif

            @if ($portfolio->email)
                <p class="creative-hero-description">
                    {{ $portfolio->email }}
                </p>
            @endif
        </div>

        <div class="creative-profile-frame">
            @if ($portfolio->profile_picture_path)
                <img
                    src="{{ asset('storage/' . $portfolio->profile_picture_path) }}"
                    alt="{{ $portfolio->full_name }}"
                    class="creative-profile"
                >
            @else
                <div class="creative-profile">
                    {{ collect(explode(' ', trim($portfolio->full_name)))->filter()->take(2)->map(fn ($name) => strtoupper(substr($name, 0, 1)))->implode('') }}
                </div>
            @endif
        </div>

    </section>

    @if ($portfolio->about_me)
        <section id="about" class="creative-container creative-section">
            <h2 class="creative-section-heading">
                <span class="creative-section-number">01 /</span>
                About Me
            </h2>

            <p class="creative-about">{{ $portfolio->about_me }}</p>
        </section>
    @endif

    @if ($portfolio->skills->isNotEmpty())
        <section id="skills" class="creative-container creative-section">
            <h2 class="creative-section-heading">
                <span class="creative-section-number">02 /</span>
                What I Do
            </h2>

            <div class="creative-skill-list">
                @foreach ($portfolio->skills as $item)
                    <span class="creative-skill">{{ $item->skill_name }}</span>
                @endforeach
            </div>
        </section>
    @endif

    @if ($portfolio->projects->isNotEmpty())
        <section id="projects" class="creative-container creative-section">
            <h2 class="creative-section-heading">
                <span class="creative-section-number">03 /</span>
                Selected Projects
            </h2>

            <div class="creative-grid">
                @foreach ($portfolio->projects as $item)
                    <article class="creative-card">
                        @if ($item->title)
                            <h3>{{ $item->title }}</h3>
                        @endif

                        @if ($item->description)
                            <p>{{ $item->description }}</p>
                        @endif

                        @if ($item->link)
                            <a
                                href="{{ $item->link }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="creative-project-link"
                            >
                                Explore Project ↗
                            </a>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if ($portfolio->education->isNotEmpty())
        <section class="creative-container creative-section">
            <h2 class="creative-section-heading">
                <span class="creative-section-number">04 /</span>
                Education
            </h2>

            <div class="creative-grid">
                @foreach ($portfolio->education as $item)
                    <article class="creative-card">
                        @if ($item->school)
                            <h3>{{ $item->school }}</h3>
                        @endif

                        @if ($item->course_program)
                            <p>{{ $item->course_program }}</p>
                        @endif

                        @if ($item->year)
                            <p class="creative-meta">{{ $item->year }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if ($portfolio->experiences->isNotEmpty())
        <section class="creative-container creative-section">
            <h2 class="creative-section-heading">
                <span class="creative-section-number">05 /</span>
                Experience
            </h2>

            <div class="creative-grid">
                @foreach ($portfolio->experiences as $item)
                    <article class="creative-card">
                        @if ($item->position)
                            <h3>{{ $item->position }}</h3>
                        @endif

                        @if ($item->organization)
                            <p class="creative-meta">{{ $item->organization }}</p>
                        @endif

                        @if ($item->description)
                            <p>{{ $item->description }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if ($portfolio->email || $portfolio->contact_number ||
         $portfolio->address || $portfolio->website_url ||
         $portfolio->facebook_url || $portfolio->linkedin_url ||
         $portfolio->github_url)

        <section id="contact" class="creative-container creative-section">
            <h2 class="creative-section-heading">
                <span class="creative-section-number">06 /</span>
                Let's Connect
            </h2>

            <div class="creative-contact">

                @if ($portfolio->email)
                    <div class="creative-contact-item">
                        <span class="creative-contact-label">Email</span>
                        <a href="mailto:{{ $portfolio->email }}">
                            {{ $portfolio->email }}
                        </a>
                    </div>
                @endif

                @if ($portfolio->contact_number)
                    <div class="creative-contact-item">
                        <span class="creative-contact-label">Phone</span>
                        {{ $portfolio->contact_number }}
                    </div>
                @endif

                @if ($portfolio->address)
                    <div class="creative-contact-item">
                        <span class="creative-contact-label">Location</span>
                        {{ $portfolio->address }}
                    </div>
                @endif

                @if ($portfolio->website_url)
                    <div class="creative-contact-item">
                        <span class="creative-contact-label">Website</span>
                        <a href="{{ $portfolio->website_url }}" target="_blank" rel="noopener noreferrer">
                            Visit Website ↗
                        </a>
                    </div>
                @endif

                @if ($portfolio->facebook_url)
                    <div class="creative-contact-item">
                        <span class="creative-contact-label">Facebook</span>
                        <a href="{{ $portfolio->facebook_url }}" target="_blank" rel="noopener noreferrer">
                            Visit Profile ↗
                        </a>
                    </div>
                @endif

                @if ($portfolio->linkedin_url)
                    <div class="creative-contact-item">
                        <span class="creative-contact-label">LinkedIn</span>
                        <a href="{{ $portfolio->linkedin_url }}" target="_blank" rel="noopener noreferrer">
                            Visit Profile ↗
                        </a>
                    </div>
                @endif

                @if ($portfolio->github_url)
                    <div class="creative-contact-item">
                        <span class="creative-contact-label">GitHub</span>
                        <a href="{{ $portfolio->github_url }}" target="_blank" rel="noopener noreferrer">
                            View Projects ↗
                        </a>
                    </div>
                @endif

            </div>
        </section>
    @endif

</main>

<footer class="creative-footer">
    Designed with creativity · Portfolio Generator
</footer>

</body>
</html>
