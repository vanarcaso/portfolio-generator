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
    const params = new URLSearchParams(location.search);
const previewTemplate = params.get("preview");

if (previewTemplate) {
    showSamplePreview(previewTemplate);
    return;
}

const id = params.get("id");

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

if (!p.selected_template) {
    location.href = "templates.html";
    return;
}

if (p.selected_template === "simple") {
    simple(data);
} else if (p.selected_template === "modern") {
    modern(data);
} else if (p.selected_template === "creative") {
    creative(data);
} else {
    location.href = "templates.html";
}
}

/* SAMPLE TEMPLATE PREVIEW */

function showSamplePreview(templateName) {
    const sampleData = {
        p: {
            full_name: "Jordan Lee",
            profile_picture_url: "images/profile_pic.jpg",
            email: "jordan.lee@example.com",
            contact_number: "000-000-0000",
            address: "Sample City, Philippines",
            about_me: "I am an IT student who enjoys building websites and learning new web technologies.",
            website_url: "https://example.com",
            facebook_url: "",
            linkedin_url: "",
            github_url: ""
        },

        education: [
            {
                school: "Northview College",
                course_program: "BS Information Technology",
                year: "3rd Year"
            }
        ],

        skills: [
            { skill_name: "HTML" },
            { skill_name: "CSS" },
            { skill_name: "JavaScript" },
            { skill_name: "Supabase" }
        ],

        projects: [
            {
                title: "Campus Event Hub",
                description: "A responsive website that helps students find campus events.",
                link: "https://example.com"
            }
        ],

        experiences: [
            {
                position: "Student Developer",
                organization: "Campus Tech Club",
                description: "Helped build web pages and improve mobile layouts."
            }
        ]
    };

    if (templateName === "simple") {
        simple(sampleData);
    } else if (templateName === "modern") {
        modern(sampleData);
    } else if (templateName === "creative") {
        creative(sampleData);
    } else {
        view.innerHTML = `
            <p class="loading">
                Template not found.
                <a href="templates.html">Back to templates</a>
            </p>
        `;
        return;
    }

    const title = templateName.charAt(0).toUpperCase()
        + templateName.slice(1);

    document.title = `${title} Template Preview`;

    const navLinks = document.querySelector(".portfolio-nav div");

    if (navLinks) {
        navLinks.innerHTML = `
            <a href="index.html">Home</a>
            <a href="templates.html">Back to Templates</a>
        `;
    }

   const notice = document.createElement("div");

notice.setAttribute("role", "note");

notice.innerHTML =
    "<strong>Sample preview only:</strong> This is just a sample information. This preview does not save, change, or replace your portfolio. When you select this template for your own portfolio, your saved information will appear in this design.";

// Match the sign to each template's design
const isCreative = templateName === "creative";

const noticeWidth =
    templateName === "simple" ? "950px" : "1050px";

const noticeBackground =
    isCreative ? "#f5f3ff" : "#eff6ff";

const noticeBorder =
    isCreative ? "#ddd6fe" : "#bfdbfe";

const noticeAccent =
    isCreative ? "#8b5cf6" : "#2563eb";

const noticeTextColor =
    isCreative ? "#4c1d95" : "#1e40af";

// Style the sample-preview sign
notice.style.cssText =
    "box-sizing:border-box;" +
    "display:block;" +
    "width:calc(100% - 32px);" +
    "max-width:" + noticeWidth + ";" +
    "margin:20px auto 0;" +
    "padding:18px 22px;" +
    "background:" + noticeBackground + ";" +
    "border:1px solid " + noticeBorder + ";" +
    "border-left:6px solid " + noticeAccent + ";" +
    "border-radius:14px;" +
    "color:" + noticeTextColor + ";" +
    "font-size:16px;" +
    "line-height:1.65;" +
    "box-shadow:0 10px 26px rgba(15,23,42,0.10);";

view.parentNode.insertBefore(notice, view);
/* HELPERS */


function photo(p) {
    if (!p.profile_picture_url) {
        if (new URLSearchParams(location.search).has("preview")) {
            return `
                <div class="profile-photo"
                     style="display:flex;align-items:center;justify-content:center;background:#dbeafe;color:#1d4ed8;font-size:36px;font-weight:bold;">
                    JL
                </div>
            `;
        }

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
