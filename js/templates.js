const view = document.getElementById("portfolioView");


/* SELECT TEMPLATE */

document.querySelectorAll(".choose-template").forEach(button => {
    button.onclick = async () => {
        const id = localStorage.getItem("portfolio_id");

        if (!id) {
            alert("Create a portfolio first.");
            location.href = "portfolio-form.html";
            return;
        }

        const { error } = await db
            .from("portfolios")
            .update({ selected_template: button.dataset.template })
            .eq("id", id);

        if (error) {
            alert(error.message);
            return;
        }

        location.href = `portfolio.html?id=${id}`;
    };
});


/* LOAD PORTFOLIO */

if (view) {
    loadPortfolio();
}

async function loadPortfolio() {
    const id = new URLSearchParams(location.search).get("id");

    if (!id) {
        view.innerHTML = "<p>Portfolio not found.</p>";
        return;
    }

    const { data: p } = await db
        .from("portfolios")
        .select("*")
        .eq("id", id)
        .maybeSingle();

    if (!p) {
        view.innerHTML = "<p>Portfolio not found.</p>";
        return;
    }

    const [edu, skill, project, exp] = await Promise.all([
        db.from("education").select("*").eq("portfolio_id", id),
        db.from("skills").select("*").eq("portfolio_id", id),
        db.from("projects").select("*").eq("portfolio_id", id),
        db.from("experiences").select("*").eq("portfolio_id", id)
    ]);

    const data = {
        p: p,
        education: edu.data || [],
        skills: skill.data || [],
        projects: project.data || [],
        experiences: exp.data || []
    };

    if (!p.selected_template) {
    location.href = "templates.html";
    return;
}

if (p.selected_template === "simple") {
    portfolioView.innerHTML = simple(data);
} else if (p.selected_template === "modern") {
    portfolioView.innerHTML = modern(data);
} else if (p.selected_template === "creative") {
    portfolioView.innerHTML = creative(data);
} else {
    location.href = "templates.html";
}

}
/* HELPERS */

function photo(p) {
    if (!p.profile_picture_url) {
        return "";
    }

    return `
        <img class="profile-photo"
             src="${p.profile_picture_url}"
             alt="Profile Picture">
    `;
}

function skills(items) {
    return items
        .map(item => `<span>${item.skill_name}</span>`)
        .join("");
}

function education(items) {
    return items
        .map(item => `
            <h3>${item.school || ""}</h3>
            <p>${item.course_program || ""} ${item.year || ""}</p>
        `)
        .join("");
}

function projects(items) {
    return items
        .map(item => `
            <h3>${item.title || ""}</h3>
            <p>${item.description || ""}</p>
            ${
                item.link
                    ? `<a href="${item.link}" target="_blank">View Project</a>`
                    : ""
            }
        `)
        .join("");
}

function experience(items) {
    return items
        .map(item => `
            <h3>${item.position || ""}</h3>
            <p>${item.organization || ""}</p>
            <p>${item.description || ""}</p>
        `)
        .join("");
}

function links(p) {
    return `
        ${p.website_url
            ? `<a href="${p.website_url}" target="_blank">Website</a>`
            : ""}

        ${p.facebook_url
            ? `<a href="${p.facebook_url}" target="_blank">Facebook</a>`
            : ""}

        ${p.linkedin_url
            ? `<a href="${p.linkedin_url}" target="_blank">LinkedIn</a>`
            : ""}

        ${p.github_url
            ? `<a href="${p.github_url}" target="_blank">GitHub</a>`
            : ""}
    `;
}


/* SIMPLE */

function simple(data) {
    const p = data.p;
    let course = "";

    if (data.education.length > 0) {
        course = data.education[0].course_program || "";
    }

    view.innerHTML = `
        <main class="simple-layout">

            <header class="simple-header">
                <div class="simple-info">
                    <h1>${p.full_name}</h1>
                    <p>${course}</p>
                </div>

                <div>
                    ${photo(p)}
                </div>
            </header>

            <section class="simple-about">
                <h2>About Me</h2>
                <p>${p.about_me || ""}</p>
            </section>

            <div class="simple-grid">

                <section>
                    <h2>Education</h2>
                    ${education(data.education)}
                </section>

                <section>
                    <h2>Skills</h2>
                    <div class="skills">
                        ${skills(data.skills)}
                    </div>
                </section>

                <section>
                    <h2>Projects</h2>
                    ${projects(data.projects)}
                </section>

                <section>
                    <h2>Contact</h2>
                    <p>${p.email || ""}</p>
                    <p>${p.contact_number || ""}</p>
                    <p>${p.address || ""}</p>

                    <div class="links">
                        ${links(p)}
                    </div>
                </section>

            </div>

            <section class="simple-experience">
                <h2>Work Experience</h2>
                ${experience(data.experiences)}
            </section>

        </main>
    `;
}


/* MODERN */

function modern(data) {
    const p = data.p;
    let course = "";

    if (data.education.length > 0) {
        course = data.education[0].course_program || "";
    }

    view.innerHTML = `
        <main class="modern-layout">

            <section class="modern-hero">
                ${photo(p)}

                <h1>${p.full_name}</h1>
                <p class="modern-course">${course}</p>
                <p class="modern-about">${p.about_me || ""}</p>

                <div class="modern-links">
                    ${links(p)}
                </div>
            </section>

            <div class="modern-grid">

                <section class="modern-card">
                    <h2>Contact</h2>
                    <p>${p.email || ""}</p>
                    <p>${p.contact_number || ""}</p>
                    <p>${p.address || ""}</p>
                </section>

                <section class="modern-card">
                    <h2>Education</h2>
                    ${education(data.education)}
                </section>

                <section class="modern-card">
                    <h2>Skills</h2>
                    <div class="skills">
                        ${skills(data.skills)}
                    </div>
                </section>

                <section class="modern-card">
                    <h2>Projects</h2>
                    ${projects(data.projects)}
                </section>

                <section class="modern-card modern-wide">
                    <h2>Work Experience</h2>
                    ${experience(data.experiences)}
                </section>

            </div>

        </main>
    `;
}


/* CREATIVE */

function creative(data) {
    const p = data.p;
    let course = "";

    if (data.education.length > 0) {
        course = data.education[0].course_program || "";
    }

    view.innerHTML = `
        <main class="creative-layout">

            <section class="creative-hero">

                <div class="creative-photo">
                    ${photo(p)}
                </div>

                <div class="creative-intro">
                    <p class="creative-hello">Hi, I'm</p>
                    <h1>${p.full_name}</h1>
                    <p class="creative-course">${course}</p>

                    <div class="creative-links">
                        ${links(p)}
                    </div>
                </div>

            </section>

            <section class="creative-about">
                <h2>About Me</h2>
                <p>${p.about_me || ""}</p>
            </section>

            <div class="creative-grid">

                <section class="creative-card">
                    <h2>Education</h2>
                    ${education(data.education)}
                </section>

                <section class="creative-card">
                    <h2>Skills</h2>
                    <div class="skills">
                        ${skills(data.skills)}
                    </div>
                </section>

                <section class="creative-card">
                    <h2>Projects</h2>
                    ${projects(data.projects)}
                </section>

                <section class="creative-card">
                    <h2>Work Experience</h2>
                    ${experience(data.experiences)}
                </section>

            </div>

            <section class="creative-contact">
                <h2>Contact</h2>
                <p>${p.email || ""}</p>
                <p>${p.contact_number || ""}</p>
                <p>${p.address || ""}</p>
            </section>

        </main>
    `;
}

const templateBackButton = document.getElementById("templateBackButton");

if (templateBackButton) {
    templateBackButton.addEventListener("click", async function () {
        const id = localStorage.getItem("portfolio_id");

        if (!id) {
            location.href = "portfolio-form.html";
            return;
        }

        const { data } = await db
            .from("portfolios")
            .select("selected_template")
            .eq("id", id)
            .maybeSingle();

        if (data && data.selected_template) {
            location.href = "manage.html";
        } else {
            location.href = "portfolio-form.html";
        }
    });
}
