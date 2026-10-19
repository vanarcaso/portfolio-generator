
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Portfolio | Portfolio Generator</title>

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
            <a href="{{ route('portfolio.create') }}" class="active">
                Create Portfolio
            </a>
        </div>
    </nav>
</header>

<main class="portfolio-main">
    <section class="portfolio-card">
        <h1 class="portfolio-title">Create Your Portfolio</h1>

        <p class="portfolio-description">
            Enter your information below to build your professional portfolio.
            Fields marked with * are required.
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

        @if (session('success'))
            <div style="padding: 12px; margin-bottom: 20px; background: #dcfce7; color: #166534; border-radius: 8px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('portfolio.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <section class="portfolio-section">
                <h2 class="portfolio-section-title">Personal Information</h2>

                <div class="portfolio-grid">
                    <div class="portfolio-field">
                        <label for="full_name">Full Name *</label>
                        <input type="text" id="full_name" name="full_name"
                               value="{{ old('full_name') }}" required>
                    </div>

                    <div class="portfolio-field">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" id="profile_picture"
                               name="profile_picture"
                               accept=".jpg,.jpeg,.png,.webp">
                    </div>

                    <div class="portfolio-field">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email', auth()->user()->email) }}"
                               required>
                    </div>

                    <div class="portfolio-field">
                        <label for="contact_number">Contact Number</label>
                        <input type="tel" id="contact_number"
                               name="contact_number"
                               value="{{ old('contact_number') }}">
                    </div>

                    <div class="portfolio-field full-width">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address"
                               value="{{ old('address') }}">
                    </div>

                    <div class="portfolio-field full-width">
                        <label for="about_me">About Me</label>
                        <textarea id="about_me" name="about_me"
                                  placeholder="Introduce yourself...">{{ old('about_me') }}</textarea>
                    </div>
                </div>
            </section>

            <section class="portfolio-section">
                <h2 class="portfolio-section-title">Education</h2>

                <div class="repeat-list" id="education-list"
                     data-section="education">
                    <div class="repeat-row">
                        <div class="portfolio-grid">
                            <div class="portfolio-field">
                                <label>School</label>
                                <input type="text" name="education[0][school]">
                            </div>

                            <div class="portfolio-field">
                                <label>Course / Program</label>
                                <input type="text"
                                       name="education[0][course_program]">
                            </div>

                            <div class="portfolio-field">
                                <label>Year</label>
                                <input type="text" name="education[0][year]"
                                       placeholder="e.g. 2024–2026">
                            </div>
                        </div>

                        <div class="repeat-actions">
                            <span></span>
                            <button type="button" class="remove-button"
                                    onclick="removeRow(this)">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>

                <div class="repeat-actions">
                    <button type="button" class="secondary-button"
                            onclick="addRow('education-list')">
                        + Add Education
                    </button>
                </div>
            </section>

            <section class="portfolio-section">
                <h2 class="portfolio-section-title">Skills</h2>

                <div class="repeat-list" id="skills-list" data-section="skills">
                    <div class="repeat-row">
                        <div class="portfolio-field">
                            <label>Skill</label>
                            <input type="text" name="skills[0][skill_name]"
                                   placeholder="e.g. Web Design">
                        </div>

                        <div class="repeat-actions">
                            <span></span>
                            <button type="button" class="remove-button"
                                    onclick="removeRow(this)">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>

                <div class="repeat-actions">
                    <button type="button" class="secondary-button"
                            onclick="addRow('skills-list')">
                        + Add Skill
                    </button>
                </div>
            </section>

            <section class="portfolio-section">
                <h2 class="portfolio-section-title">Projects</h2>

                <div class="repeat-list" id="projects-list"
                     data-section="projects">
                    <div class="repeat-row">
                        <div class="portfolio-grid">
                            <div class="portfolio-field">
                                <label>Project Title</label>
                                <input type="text" name="projects[0][title]">
                            </div>

                            <div class="portfolio-field">
                                <label>Project Link</label>
                                <input type="url" name="projects[0][link]"
                                       placeholder="https://example.com">
                            </div>

                            <div class="portfolio-field full-width">
                                <label>Description</label>
                                <textarea name="projects[0][description]"></textarea>
                            </div>
                        </div>

                        <div class="repeat-actions">
                            <span></span>
                            <button type="button" class="remove-button"
                                    onclick="removeRow(this)">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>

                <div class="repeat-actions">
                    <button type="button" class="secondary-button"
                            onclick="addRow('projects-list')">
                        + Add Project
                    </button>
                </div>
            </section>

            <section class="portfolio-section">
                <h2 class="portfolio-section-title">Work Experience</h2>

                <div class="repeat-list" id="experiences-list"
                     data-section="experiences">
                    <div class="repeat-row">
                        <div class="portfolio-grid">
                            <div class="portfolio-field">
                                <label>Organization / Company</label>
                                <input type="text"
                                       name="experiences[0][organization]">
                            </div>

                            <div class="portfolio-field">
                                <label>Position</label>
                                <input type="text"
                                       name="experiences[0][position]">
                            </div>

                            <div class="portfolio-field full-width">
                                <label>Description</label>
                                <textarea name="experiences[0][description]"
                                          placeholder="Describe your responsibilities..."></textarea>
                            </div>
                        </div>

                        <div class="repeat-actions">
                            <span></span>
                            <button type="button" class="remove-button"
                                    onclick="removeRow(this)">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>

                <div class="repeat-actions">
                    <button type="button" class="secondary-button"
                            onclick="addRow('experiences-list')">
                        + Add Experience
                    </button>
                </div>
            </section>

            <section class="portfolio-section">
                <h2 class="portfolio-section-title">Social Links and Template</h2>

                <div class="portfolio-grid">
                    <div class="portfolio-field">
                        <label for="website_url">Personal Website</label>
                        <input type="url" id="website_url" name="website_url"
                               value="{{ old('website_url') }}"
                               placeholder="https://example.com">
                    </div>

                    <div class="portfolio-field">
                        <label for="facebook_url">Facebook URL</label>
                        <input type="url" id="facebook_url"
                               name="facebook_url"
                               value="{{ old('facebook_url') }}"
                               placeholder="https://facebook.com/...">
                    </div>

                    <div class="portfolio-field">
                        <label for="linkedin_url">LinkedIn URL</label>
                        <input type="url" id="linkedin_url"
                               name="linkedin_url"
                               value="{{ old('linkedin_url') }}"
                               placeholder="https://linkedin.com/...">
                    </div>

                    <div class="portfolio-field">
                        <label for="github_url">GitHub URL</label>
                        <input type="url" id="github_url" name="github_url"
                               value="{{ old('github_url') }}"
                               placeholder="https://github.com/...">
                    </div>

                    <div class="portfolio-field full-width">
                        <label for="selected_template">Portfolio Template *</label>
                        <select id="selected_template" name="selected_template"
                                required>
                            <option value="simple"
                                {{ old('selected_template', 'simple') === 'simple' ? 'selected' : '' }}>
                                Simple — Clean and Professional
                            </option>
                            <option value="modern"
                                {{ old('selected_template') === 'modern' ? 'selected' : '' }}>
                                Modern — Cards and Visuals
                            </option>
                            <option value="creative"
                                {{ old('selected_template') === 'creative' ? 'selected' : '' }}>
                                Creative — Artistic Layout
                            </option>
                        </select>
                    </div>
                </div>
            </section>

            <button type="submit" class="portfolio-submit">
                Save Portfolio
            </button>
        </form>
    </section>
</main>

<script>
function reindexRows(list) {
    const section = list.dataset.section;

    list.querySelectorAll('.repeat-row').forEach((row, index) => {
        row.querySelectorAll('[name]').forEach((field) => {
            field.name = field.name.replace(
                new RegExp(section + '\\\\[\\\\d+\\\\]'),
                section + '[' + index + ']'
            );
        });
    });
}

function addRow(listId) {
    const list = document.getElementById(listId);
    const firstRow = list.querySelector('.repeat-row');
    const newRow = firstRow.cloneNode(true);

    newRow.querySelectorAll('input, textarea').forEach((field) => {
        field.value = '';
    });

    list.appendChild(newRow);
    reindexRows(list);
}

function removeRow(button) {
    const row = button.closest('.repeat-row');
    const list = button.closest('.repeat-list');

    if (list.querySelectorAll('.repeat-row').length > 1) {
        row.remove();
        reindexRows(list);
    } else {
        row.querySelectorAll('input, textarea').forEach((field) => {
            field.value = '';
        });
    }
}
</script>

</body>
</html>
