
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Portfolio | Portfolio Generator</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <style>
        .edit-section {
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .edit-section h2 {
            color: #0f172a;
            font-size: 20px;
            margin: 0 0 20px;
        }

        .edit-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .edit-field {
            min-width: 0;
            margin-bottom: 12px;
        }

        .edit-field.full {
            grid-column: 1 / -1;
        }

        .edit-field label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
        }

        .edit-field input,
        .edit-field textarea,
        .edit-field select {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #ffffff;
            color: #0f172a;
            font: inherit;
        }

        .edit-field textarea {
            min-height: 100px;
            resize: vertical;
        }

        .edit-row {
            padding: 18px;
            margin-bottom: 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
        }

        .edit-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin: 12px 0;
        }

        .edit-add,
        .edit-remove {
            padding: 10px 14px;
            border: 0;
            border-radius: 7px;
            font-weight: 600;
            cursor: pointer;
        }

        .edit-add {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .edit-remove {
            background: #fee2e2;
            color: #b91c1c;
        }

        .edit-row:only-child .edit-remove {
            display: none;
        }

        .edit-submit {
            display: block;
            width: 100%;
            margin-top: 30px;
            padding: 14px;
            border: 0;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
        }

        .edit-cancel {
            display: block;
            margin-top: 16px;
            text-align: center;
            color: #2563eb;
            text-decoration: none;
        }

        @media (max-width: 650px) {
            .edit-grid {
                grid-template-columns: 1fr;
            }

            .edit-field.full {
                grid-column: auto;
            }
        }
    </style>
</head>
<body class="auth-page">

@php
    $educationRows = old('education', $portfolio->education->map(fn ($item) => [
        'school' => $item->school,
        'course_program' => $item->course_program,
        'year' => $item->year,
    ])->all());

    $skillsRows = old('skills', $portfolio->skills->map(fn ($item) => [
        'skill_name' => $item->skill_name,
    ])->all());

    $projectRows = old('projects', $portfolio->projects->map(fn ($item) => [
        'title' => $item->title,
        'description' => $item->description,
        'link' => $item->link,
    ])->all());

    $experienceRows = old('experiences', $portfolio->experiences->map(fn ($item) => [
        'organization' => $item->organization,
        'position' => $item->position,
        'description' => $item->description,
    ])->all());

    if (empty($educationRows)) {
        $educationRows = [['school' => '', 'course_program' => '', 'year' => '']];
    }

    if (empty($skillsRows)) {
        $skillsRows = [['skill_name' => '']];
    }

    if (empty($projectRows)) {
        $projectRows = [['title' => '', 'description' => '', 'link' => '']];
    }

    if (empty($experienceRows)) {
        $experienceRows = [['organization' => '', 'position' => '', 'description' => '']];
    }
@endphp

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

<main class="portfolio-main">
    <section class="portfolio-card">
        <h1 class="portfolio-title">Edit Your Portfolio</h1>

        <p class="portfolio-description">
            Update your information below. Your changes will be saved
            to your existing portfolio.
        </p>

        @if ($errors->any())
            <div class="auth-alert">
                <strong>Please check your information.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/portfolio/update') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <section class="edit-section">
                <h2>Personal Information</h2>

                @if ($portfolio->profile_picture_path)
                    <p>Current profile picture:</p>
                    <img
                        src="{{ asset('storage/' . $portfolio->profile_picture_path) }}"
                        alt="Current profile picture"
                        style="width:100px;height:100px;object-fit:cover;border-radius:50%;margin-bottom:16px;"
                    >
                @endif

                <div class="edit-grid">
                    <div class="edit-field">
                        <label for="full_name">Full Name *</label>
                        <input id="full_name" name="full_name" required
                               value="{{ old('full_name', $portfolio->full_name) }}">
                    </div>

                    <div class="edit-field">
                        <label for="profile_picture">Change Profile Picture</label>
                        <input type="file" id="profile_picture"
                               name="profile_picture"
                               accept=".jpg,.jpeg,.png,.webp">
                    </div>

                    <div class="edit-field">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required
                               value="{{ old('email', $portfolio->email) }}">
                    </div>

                    <div class="edit-field">
                        <label for="contact_number">Contact Number</label>
                        <input id="contact_number" name="contact_number"
                               value="{{ old('contact_number', $portfolio->contact_number) }}">
                    </div>

                    <div class="edit-field full">
                        <label for="address">Address</label>
                        <input id="address" name="address"
                               value="{{ old('address', $portfolio->address) }}">
                    </div>

                    <div class="edit-field full">
                        <label for="about_me">About Me</label>
                        <textarea id="about_me" name="about_me">{{ old('about_me', $portfolio->about_me) }}</textarea>
                    </div>
                </div>
            </section>

            <section class="edit-section">
                <h2>Education</h2>

                <div id="education-list" data-section="education">
                    @foreach ($educationRows as $i => $item)
                        <div class="edit-row">
                            <div class="edit-grid">
                                <div class="edit-field">
                                    <label>School</label>
                                    <input name="education[{{ $i }}][school]"
                                           value="{{ $item['school'] ?? '' }}">
                                </div>

                                <div class="edit-field">
                                    <label>Course / Program</label>
                                    <input name="education[{{ $i }}][course_program]"
                                           value="{{ $item['course_program'] ?? '' }}">
                                </div>

                                <div class="edit-field">
                                    <label>Year</label>
                                    <input name="education[{{ $i }}][year]"
                                           value="{{ $item['year'] ?? '' }}">
                                </div>
                            </div>

                            <div class="edit-actions">
                                <span></span>
                                <button type="button" class="edit-remove"
                                        onclick="removeEditRow(this)">
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="edit-add"
                        onclick="addEditRow('education-list')">
                    + Add Education
                </button>
            </section>

            <section class="edit-section">
                <h2>Skills</h2>

                <div id="skills-list" data-section="skills">
                    @foreach ($skillsRows as $i => $item)
                        <div class="edit-row">
                            <div class="edit-field">
                                <label>Skill</label>
                                <input name="skills[{{ $i }}][skill_name]"
                                       value="{{ $item['skill_name'] ?? '' }}">
                            </div>

                            <div class="edit-actions">
                                <span></span>
                                <button type="button" class="edit-remove"
                                        onclick="removeEditRow(this)">
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="edit-add"
                        onclick="addEditRow('skills-list')">
                    + Add Skill
                </button>
            </section>

            <section class="edit-section">
                <h2>Projects</h2>

                <div id="projects-list" data-section="projects">
                    @foreach ($projectRows as $i => $item)
                        <div class="edit-row">
                            <div class="edit-grid">
                                <div class="edit-field">
                                    <label>Project Title</label>
                                    <input name="projects[{{ $i }}][title]"
                                           value="{{ $item['title'] ?? '' }}">
                                </div>

                                <div class="edit-field">
                                    <label>Project Link</label>
                                    <input type="url"
                                           name="projects[{{ $i }}][link]"
                                           value="{{ $item['link'] ?? '' }}">
                                </div>

                                <div class="edit-field full">
                                    <label>Description</label>
                                    <textarea name="projects[{{ $i }}][description]">{{ $item['description'] ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="edit-actions">
                                <span></span>
                                <button type="button" class="edit-remove"
                                        onclick="removeEditRow(this)">
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="edit-add"
                        onclick="addEditRow('projects-list')">
                    + Add Project
                </button>
            </section>

            <section class="edit-section">
                <h2>Work Experience</h2>

                <div id="experiences-list" data-section="experiences">
                    @foreach ($experienceRows as $i => $item)
                        <div class="edit-row">
                            <div class="edit-grid">
                                <div class="edit-field">
                                    <label>Organization / Company</label>
                                    <input name="experiences[{{ $i }}][organization]"
                                           value="{{ $item['organization'] ?? '' }}">
                                </div>

                                <div class="edit-field">
                                    <label>Position</label>
                                    <input name="experiences[{{ $i }}][position]"
                                           value="{{ $item['position'] ?? '' }}">
                                </div>

                                <div class="edit-field full">
                                    <label>Description</label>
                                    <textarea name="experiences[{{ $i }}][description]">{{ $item['description'] ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="edit-actions">
                                <span></span>
                                <button type="button" class="edit-remove"
                                        onclick="removeEditRow(this)">
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="edit-add"
                        onclick="addEditRow('experiences-list')">
                    + Add Experience
                </button>
            </section>

            <section class="edit-section">
                <h2>Social Links and Template</h2>

                <div class="edit-grid">
                    <div class="edit-field">
                        <label for="website_url">Personal Website</label>
                        <input type="url" id="website_url" name="website_url"
                               value="{{ old('website_url', $portfolio->website_url) }}">
                    </div>

                    <div class="edit-field">
                        <label for="facebook_url">Facebook URL</label>
                        <input type="url" id="facebook_url" name="facebook_url"
                               value="{{ old('facebook_url', $portfolio->facebook_url) }}">
                    </div>

                    <div class="edit-field">
                        <label for="linkedin_url">LinkedIn URL</label>
                        <input type="url" id="linkedin_url" name="linkedin_url"
                               value="{{ old('linkedin_url', $portfolio->linkedin_url) }}">
                    </div>

                    <div class="edit-field">
                        <label for="github_url">GitHub URL</label>
                        <input type="url" id="github_url" name="github_url"
                               value="{{ old('github_url', $portfolio->github_url) }}">
                    </div>

                    <div class="edit-field full">
                        <label for="selected_template">Portfolio Template *</label>
                        <select id="selected_template" name="selected_template" required>
                            <option value="simple"
                                {{ old('selected_template', $portfolio->selected_template) === 'simple' ? 'selected' : '' }}>
                                Simple — Clean and Professional
                            </option>
                            <option value="modern"
                                {{ old('selected_template', $portfolio->selected_template) === 'modern' ? 'selected' : '' }}>
                                Modern — Cards and Visuals
                            </option>
                            <option value="creative"
                                {{ old('selected_template', $portfolio->selected_template) === 'creative' ? 'selected' : '' }}>
                                Creative — Artistic Layout
                            </option>
                        </select>
                    </div>
                </div>
            </section>

            <button type="submit" class="edit-submit">
                Save Changes
            </button>
        </form>

        <a href="{{ route('portfolio.manage') }}" class="edit-cancel">
            Cancel and return to Manage Portfolio
        </a>
    </section>
</main>

<script>
function reindexEditRows(list) {
    const section = list.dataset.section;

    list.querySelectorAll('.edit-row').forEach((row, index) => {
        row.querySelectorAll('[name]').forEach((field) => {
            field.name = field.name.replace(
                new RegExp(section + '\\[\\d+\\]'),
                section + '[' + index + ']'
            );
        });
    });

    list.querySelectorAll('.edit-remove').forEach((button) => {
        button.style.display =
            list.querySelectorAll('.edit-row').length > 1 ? '' : 'none';
    });
}

function addEditRow(listId) {
    const list = document.getElementById(listId);
    const newRow = list.querySelector('.edit-row').cloneNode(true);

    newRow.querySelectorAll('input, textarea').forEach((field) => {
        field.value = '';
    });

    list.appendChild(newRow);
    reindexEditRows(list);
}

function removeEditRow(button) {
    const row = button.closest('.edit-row');
    const list = row.parentElement;

    if (list.querySelectorAll('.edit-row').length > 1) {
        row.remove();
        reindexEditRows(list);
    } else {
        row.querySelectorAll('input, textarea').forEach((field) => {
            field.value = '';
        });
    }
}

document.querySelectorAll('[data-section]').forEach(reindexEditRows);
</script>

</body>
</html>
