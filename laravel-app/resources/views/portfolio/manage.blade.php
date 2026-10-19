
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Portfolio | Portfolio Generator</title>

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <style>
        /* Manage Portfolio layout */
        .manage-main {
            min-height: calc(100vh - 70px);
            padding: 60px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .manage-card {
            width: 100%;
            max-width: 750px;
            padding: 25px;
            background: #ffffff;
            color: #0f172a;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .manage-label {
            margin: 12px 0 30px;
            color: #2563eb;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .manage-name {
            margin: 0 0 25px;
            color: #0f172a;
            font-size: 32px;
            line-height: 1.25;
            overflow-wrap: anywhere;
        }

        .manage-info {
            margin: 0 0 18px;
            color: #334155;
            font-size: 16px;
            overflow-wrap: anywhere;
        }

        .manage-message {
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            line-height: 1.5;
        }

        .manage-success {
            background: #dcfce7;
            color: #166534;
        }

        .manage-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .manage-actions {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin-top: 28px;
        }

        .manage-actions form {
            width: 100%;
            margin: 0;
        }

        .manage-button {
            display: flex;
            width: 100%;
            min-height: 53px;
            align-items: center;
            justify-content: center;
            padding: 14px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-family: inherit;
            font-size: 16px;
            font-weight: 500;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        .manage-view {
            background: #0f172a;
            color: #ffffff;
        }

        .manage-view:hover {
            background: #1e293b;
        }

        .manage-edit,
        .manage-template {
            background: #eff6ff;
            border-color: #93c5fd;
            color: #2563eb;
        }

        .manage-edit:hover,
        .manage-template:hover {
            background: #dbeafe;
        }

        .manage-delete {
            background: #dc2626;
            color: #ffffff;
        }

        .manage-delete:hover {
            background: #b91c1c;
        }

        .manage-delete:focus-visible,
        .manage-button:focus-visible {
            outline: 3px solid #93c5fd;
            outline-offset: 2px;
        }

        .manage-empty {
            margin: 0;
            color: #475569;
            line-height: 1.6;
        }

        @media (max-width: 600px) {
            .manage-main {
                padding: 30px 16px;
            }

            .manage-card {
                padding: 22px;
            }

            .manage-name {
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

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                        style="padding: 10px 16px;
                               border: 1px solid #2563eb;
                               border-radius: 7px;
                               background: #ffffff;
                               color: #2563eb;
                               cursor: pointer;">
                    Log Out
                </button>
            </form>
        </div>
    </nav>
</header>

<main class="manage-main">
    <section class="manage-card">

        <p class="manage-label">Manage Portfolio</p>

        {{-- Success message --}}
        @if (session('success'))
            <div class="manage-message manage-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error message --}}
        @if (session('error'))
            <div class="manage-message manage-error" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($portfolio)

            <h1 class="manage-name">
                {{ $portfolio->full_name }}
            </h1>

            <p class="manage-info">
                <strong>Email:</strong>
                {{ $portfolio->email }}
            </p>

            <p class="manage-info">
                <strong>Selected Template:</strong>
                {{ ucfirst($portfolio->selected_template ?? 'simple') }}
            </p>

            {{-- Show the saved palette only for Creative --}}
            @if ($portfolio->selected_template === 'creative')
                @php
                    $paletteNames = [
                        'ocean' => 'Ocean Pulse',
                        'sunset' => 'Sunset',
                        'lavender' => 'Lavender Dream',
                        'forest' => 'Forest',
                        'monochrome' => 'Monochrome',
                    ];

                    $savedPalette = $portfolio->color_palette ?? 'ocean';
                    $paletteName = $paletteNames[$savedPalette]
                        ?? 'Ocean Pulse';
                @endphp

                <p class="manage-info">
                    <strong>Color Palette:</strong>
                    {{ $paletteName }}
                </p>
            @endif

            <p class="manage-info">
                <strong>Created:</strong>
                {{ $portfolio->created_at->format('M d, Y') }}
            </p>

            <div class="manage-actions">

                {{-- View the actual selected portfolio design --}}
                <a href="{{ route('dashboard') }}"
                   class="manage-button manage-view">
                    View Portfolio
                </a>

                {{-- Edit saved information --}}
                <a href="{{ route('portfolio.edit') }}"
                   class="manage-button manage-edit">
                    Edit Information
                </a>

                {{-- Choose another template --}}
                <a href="{{ route('portfolio.template') }}"
                   class="manage-button manage-template">
                    Change Template
                </a>

                {{-- Delete with confirmation --}}
                <form action="{{ route('portfolio.destroy') }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to permanently delete your portfolio? This action cannot be undone.');">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="manage-button manage-delete">
                        Delete Portfolio
                    </button>
                </form>

            </div>

        @else

            <h1 class="manage-name">No Portfolio Yet</h1>

            <p class="manage-empty">
                You haven't created a portfolio yet. Start by entering
                your information and selecting a design.
            </p>

            <div class="manage-actions">
                <a href="{{ route('portfolio.create') }}"
                   class="manage-button manage-view">
                    Create Portfolio
                </a>
            </div>

        @endif

    </section>
</main>

</body>
</html>
