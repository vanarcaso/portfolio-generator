
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Template | Portfolio Generator</title>

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <style>
        body.auth-page {
            min-height: 100vh;
            background: #0f172a;
            color: #ffffff;
        }

        .template-page {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px 60px;
        }

        /* Back button */
        .template-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 36px;
            padding: 10px 20px;
            border: 1px solid #60a5fa;
            border-radius: 10px;
            background: rgba(30, 41, 59, 0.7);
            color: #bfdbfe;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition:
                background 0.25s ease,
                color 0.25s ease,
                border-color 0.25s ease,
                transform 0.25s ease,
                box-shadow 0.25s ease;
        }

        .template-back:hover {
            background: #2563eb;
            border-color: #60a5fa;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
        }

        .template-back:focus-visible {
            outline: 2px solid #93c5fd;
            outline-offset: 3px;
        }

        .template-eyebrow {
            margin: 0 0 18px;
            color: #93c5fd;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .template-heading {
            margin: 0 0 18px;
            color: #ffffff;
            font-size: 32px;
        }

        .template-intro {
            margin: 0 0 30px;
            color: #e2e8f0;
            line-height: 1.7;
        }

        .template-alert {
            margin-bottom: 24px;
            padding: 14px 18px;
            border-radius: 8px;
            background: #fef2f2;
            color: #b91c1c;
        }

        .template-alert ul {
            margin: 8px 0 0;
            padding-left: 22px;
        }

        /* Three template cards */
        .template-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            align-items: stretch;
        }

        .template-preview-card {
            display: flex;
            flex-direction: column;
            gap: 12px;
            min-width: 0;
            padding: 14px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            background: #ffffff;
            color: #0f172a;
            transition:
                border-color 0.2s ease,
                transform 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }

        .template-preview-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.18);
        }

        .template-preview-card:has(input:checked) {
            border-color: #2563eb;
            background: #eff6ff;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
        }

        .template-preview-image {
            display: block;
            width: 100%;
            aspect-ratio: 1.55;
            object-fit: contain;
            object-position: top center;
            border: 1px solid #e2e8f0;
            border-radius: 7px;
            background: #f8fafc;
        }

        .template-option {
            display: block;
            padding: 8px 0;
            border: 0;
            background: transparent;
            color: #0f172a;
            cursor: pointer;
            line-height: 1.6;
        }

        .template-option input {
            margin-right: 7px;
            accent-color: #2563eb;
            cursor: pointer;
        }

        .template-option strong {
            font-size: 16px;
        }

        .template-option span {
            font-size: 14px;
        }

        /* Preview buttons */
        .template-preview-button {
            display: block;
            margin-top: auto;
            padding: 11px;
            border: 1px solid #93c5fd;
            border-radius: 7px;
            background: #eff6ff;
            color: #2563eb;
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .template-preview-button:hover {
            background: #dbeafe;
        }

        /* Save template button */
        .template-submit {
            display: block;
            width: 100%;
            margin-top: 30px;
            padding: 15px;
            border: 0;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .template-submit:hover {
            background: #1d4ed8;
        }

        .template-submit:focus-visible {
            outline: 2px solid #93c5fd;
            outline-offset: 3px;
        }

        .template-cancel {
            display: block;
            margin-top: 20px;
            color: #bfdbfe;
            text-align: center;
            text-decoration: none;
        }

        .template-cancel:hover {
            text-decoration: underline;
        }

        /* Responsive layout */
        @media (max-width: 800px) {
            .template-grid {
                grid-template-columns: 1fr;
            }

            .template-preview-card {
                max-width: 520px;
                width: 100%;
                margin: 0 auto;
                box-sizing: border-box;
            }

            .template-preview-image {
                aspect-ratio: 1.7;
            }

            .template-heading {
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
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('portfolio.manage') }}">Manage Portfolio</a>
        </div>
    </nav>
</header>

@php
    $currentTemplate = old(
        'selected_template',
        $portfolio->selected_template ?? 'simple'
    );
@endphp

<main class="template-page">

    <a href="{{ route('portfolio.manage') }}" class="template-back">
        &larr; Back
    </a>

    <p class="template-eyebrow">Select Template</p>

    <h1 class="template-heading">Choose Your Portfolio Style</h1>

    <p class="template-intro">
        The previews below show sample portfolios. Your own saved
        information will appear when you select a template.
    </p>

    @if ($errors->any())
        <div class="template-alert">
            <strong>Please check your selection.</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('portfolio.template.update') }}" method="POST">
        @csrf

        <div class="template-grid">

            <!-- Simple Template -->
            <div class="template-preview-card">
                <img
                    src="{{ asset('images/simple-preview.PNG') }}"
                    alt="Simple template preview"
                    class="template-preview-image"
                >

                <label class="template-option">
                    <input
                        type="radio"
                        name="selected_template"
                        value="simple"
                        {{ $currentTemplate === 'simple' ? 'checked' : '' }}
                        required
                    >
                    <strong>Simple</strong>
                    <span>Clean and professional.</span>
                </label>

                <a
                    href="{{ asset('images/simple-preview.PNG') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="template-preview-button"
                >
                    Preview
                </a>
            </div>

            <!-- Modern Template -->
            <div class="template-preview-card">
                <img
                    src="{{ asset('images/modern-preview.PNG') }}"
                    alt="Modern template preview"
                    class="template-preview-image"
                >

                <label class="template-option">
                    <input
                        type="radio"
                        name="selected_template"
                        value="modern"
                        {{ $currentTemplate === 'modern' ? 'checked' : '' }}
                        required
                    >
                    <strong>Modern</strong>
                    <span>Cards and contemporary styling.</span>
                </label>

                <a
                    href="{{ asset('images/modern-preview.PNG') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="template-preview-button"
                >
                    Preview
                </a>
            </div>

            <!-- Creative Template -->
            <div class="template-preview-card">
                <img
                    src="{{ asset('images/creative-preview.PNG') }}"
                    alt="Creative template preview"
                    class="template-preview-image"
                >

                <label class="template-option">
                    <input
                        type="radio"
                        name="selected_template"
                        value="creative"
                        {{ $currentTemplate === 'creative' ? 'checked' : '' }}
                        required
                    >
                    <strong>Creative</strong>
                    <span>Artistic and distinctive.</span>
                </label>

                <a
                    href="{{ asset('images/creative-preview.PNG') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="template-preview-button"
                >
                    Preview
                </a>
            </div>

        </div>

        <button type="submit" class="template-submit">
            Save Template
        </button>
    </form>

    <a
        href="{{ route('portfolio.manage') }}"
        class="template-cancel"
    >
        Cancel and Return to Manage Portfolio
    </a>

</main>

</body>
</html>
