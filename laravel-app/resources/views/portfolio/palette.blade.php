
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Choose Color Palette | Portfolio Generator</title>

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        body.auth-page {
            min-height: 100vh;
            background: #0f172a;
            color: #ffffff;
        }

        .palette-page {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 44px 20px 60px;
        }

        .palette-heading {
            margin: 0 0 30px;
            font-size: 32px;
            color: #ffffff;
        }

        .palette-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .palette-card {
            display: block;
            min-width: 0;
            padding: 18px;
            border: 2px solid #334155;
            border-radius: 12px;
            background: #ffffff;
            color: #0f172a;
            cursor: pointer;
            transition: border-color 0.2s, transform 0.2s;
        }

        .palette-card:hover {
            transform: translateY(-3px);
        }

        .palette-card:has(input:checked) {
            border-color: #60a5fa;
            box-shadow: 0 0 0 2px rgba(96, 165, 250, 0.2);
        }

        .palette-radio {
            width: 18px;
            height: 18px;
            margin: 0 0 14px;
            accent-color: #2563eb;
            cursor: pointer;
        }

        .palette-preview {
            display: flex;
            height: 100px;
            overflow: hidden;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .palette-color {
            flex: 1;
        }

        .palette-name {
            margin: 16px 0 5px;
            font-size: 18px;
            font-weight: 700;
        }

        .palette-description {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            line-height: 1.5;
        }

        .palette-submit {
            width: 100%;
            margin-top: 28px;
            padding: 15px;
            border: 0;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
        }

        .palette-submit:hover {
            background: #1d4ed8;
        }

        .palette-error {
            margin-bottom: 20px;
            padding: 14px;
            border-radius: 8px;
            background: #fef2f2;
            color: #b91c1c;
        }

        .palette-back {
            display: inline-block;
            margin-top: 20px;
            color: #bfdbfe;
            text-decoration: none;
        }

        .palette-back:hover {
            text-decoration: underline;
        }

        @media (max-width: 750px) {
            .palette-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 480px) {
            .palette-grid {
                grid-template-columns: 1fr;
            }

            .palette-heading {
                font-size: 27px;
            }
        }
    </style>
</head>

<body class="auth-page">

<header class="auth-header">
    <nav class="auth-nav">
        <a href="{{ route('home') }}" class="auth-brand">
            Portfolio Generator
        </a>

        <div class="auth-nav-links">
            <a href="{{ route('portfolio.manage') }}">Manage Portfolio</a>
        </div>
    </nav>
</header>

@php
    $currentPalette = old(
        'color_palette',
        $portfolio->color_palette ?? 'ocean'
    );

    $palettes = [
        'ocean' => [
            'name' => 'Ocean Pulse',
            'description' => 'Navy, sky blue, and white',
            'colors' => ['#0F172A', '#38BDF8', '#F8FAFC'],
        ],
        'sunset' => [
            'name' => 'Sunset',
            'description' => 'Terracotta, orange, and cream',
            'colors' => ['#7C2D12', '#F97316', '#FFF7ED'],
        ],
        'lavender' => [
            'name' => 'Lavender Dream',
            'description' => 'Purple, lavender, and pale violet',
            'colors' => ['#4C1D95', '#A78BFA', '#F5F3FF'],
        ],
        'forest' => [
            'name' => 'Forest',
            'description' => 'Deep green, lime, and soft white',
            'colors' => ['#14532D', '#65A30D', '#F0FDF4'],
        ],
        'monochrome' => [
            'name' => 'Monochrome',
            'description' => 'Black, gray, and white',
            'colors' => ['#111827', '#6B7280', '#FFFFFF'],
        ],
    ];
@endphp

<main class="palette-page">

    <h1 class="palette-heading">Choose Your Color Palette</h1>

    @if ($errors->any())
        <div class="palette-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('portfolio.palette.update') }}" method="POST">
        @csrf

        <div class="palette-grid">
            @foreach ($palettes as $key => $palette)
                <label class="palette-card">

                    <input
                        class="palette-radio"
                        type="radio"
                        name="color_palette"
                        value="{{ $key }}"
                        {{ $currentPalette === $key ? 'checked' : '' }}
                        required
                    >

                    <div class="palette-preview">
                        @foreach ($palette['colors'] as $color)
                            <span
                                class="palette-color"
                                style="background: {{ $color }};"
                            ></span>
                        @endforeach
                    </div>

                    <h2 class="palette-name">{{ $palette['name'] }}</h2>

                    <p class="palette-description">
                        {{ $palette['description'] }}
                    </p>

                </label>
            @endforeach
        </div>

        <button type="submit" class="palette-submit">
            Save Palette
        </button>
    </form>

    <a href="{{ route('portfolio.template') }}" class="palette-back">
        &larr; Back to Templates
    </a>

</main>

</body>
</html>
