const PORTFOLIO_ID = "portfolio_id";

function get(id) {
    return document.getElementById(id);
}

function value(id) {
    return get(id).value.trim();
}


/* GET PORTFOLIO */

async function getPortfolio() {
    const id = localStorage.getItem(PORTFOLIO_ID);

    if (!id) {
        return null;
    }

    const { data } = await db
        .from("portfolios")
        .select("*")
        .eq("id", id)
        .maybeSingle();

    if (!data) {
        localStorage.removeItem(PORTFOLIO_ID);
        return null;
    }

    return data;
}


/* UPLOAD PHOTO */

async function uploadPhoto(id) {
    const file = get("profilePicture").files[0];

    if (!file) {
        return true;
    }

    const path = id + "/" + Date.now() + "-" + file.name;

    const { error } = await db.storage
        .from("profile-pictures")
        .upload(path, file);

    if (error) {
        get("portfolioMessage").textContent = error.message;
        return false;
    }

    const result = db.storage
        .from("profile-pictures")
        .getPublicUrl(path);

    await db
        .from("portfolios")
        .update({
            profile_picture_url: result.data.publicUrl
        })
        .eq("id", id);

    return true;
}


/* SAVE OTHER DETAILS */

async function saveDetails(id) {
    await db.from("education").delete().eq("portfolio_id", id);
    await db.from("skills").delete().eq("portfolio_id", id);
    await db.from("projects").delete().eq("portfolio_id", id);
    await db.from("experiences").delete().eq("portfolio_id", id);


    /* EDUCATION */

    if (value("school") || value("course")) {
        await db.from("education").insert({
            portfolio_id: id,
            school: value("school"),
            course_program: value("course"),
            year: value("year")
        });
    }


    /* SKILLS */

    const skillText = value("skills");

    if (skillText) {
        const skillNames = skillText.split(",");
        const skillRows = [];

        for (let skill of skillNames) {
            skill = skill.trim();

            if (skill) {
                skillRows.push({
                    portfolio_id: id,
                    skill_name: skill
                });
            }
        }

        if (skillRows.length > 0) {
            await db.from("skills").insert(skillRows);
        }
    }


    /* PROJECT */

    if (value("projectTitle")) {
        await db.from("projects").insert({
            portfolio_id: id,
            title: value("projectTitle"),
            description: value("projectDescription"),
            link: value("projectLink")
        });
    }


    /* EXPERIENCE */

    if (value("organization") || value("position")) {
        await db.from("experiences").insert({
            portfolio_id: id,
            organization: value("organization"),
            position: value("position"),
            description: value("experienceDescription")
        });
    }
}


/* SAVE OR EDIT PORTFOLIO */

const portfolioForm = get("portfolioForm");

if (portfolioForm) {
    loadForm();

    portfolioForm.addEventListener("submit", async function(event) {
        event.preventDefault();

        const oldPortfolio = await getPortfolio();

        const information = {
            full_name: value("fullName"),
            email: value("email"),
            contact_number: value("contactNumber"),
            address: value("address"),
            about_me: value("aboutMe"),
            website_url: value("website"),
            facebook_url: value("facebook"),
            linkedin_url: value("linkedin"),
            github_url: value("github")
        };

        let result;

        if (oldPortfolio) {
            result = await db
                .from("portfolios")
                .update(information)
                .eq("id", oldPortfolio.id)
                .select()
                .single();
        } else {
            result = await db
                .from("portfolios")
                .insert(information)
                .select()
                .single();
        }

        if (result.error) {
            get("portfolioMessage").textContent =
                result.error.message;

            return;
        }

        const id = result.data.id;

        localStorage.setItem(PORTFOLIO_ID, id);

        const photoSaved = await uploadPhoto(id);

        if (!photoSaved) {
            return;
        }

        await saveDetails(id);

        alert("Portfolio saved successfully!");

        if (oldPortfolio && oldPortfolio.selected_template) {
            location.href = "manage.html";
        } else {
            location.href = "templates.html";
        }
    });
}


/* LOAD FORM FOR EDIT */

async function loadForm() {
    const portfolio = await getPortfolio();

    if (!portfolio) {
        return;
    }

    get("fullName").value = portfolio.full_name || "";
    get("email").value = portfolio.email || "";
    get("contactNumber").value = portfolio.contact_number || "";
    get("address").value = portfolio.address || "";
    get("aboutMe").value = portfolio.about_me || "";

    get("website").value = portfolio.website_url || "";
    get("facebook").value = portfolio.facebook_url || "";
    get("linkedin").value = portfolio.linkedin_url || "";
    get("github").value = portfolio.github_url || "";

    const id = portfolio.id;


    /* EDUCATION */

    const education = await db
        .from("education")
        .select("*")
        .eq("portfolio_id", id)
        .maybeSingle();

    if (education.data) {
        get("school").value = education.data.school || "";
        get("course").value = education.data.course_program || "";
        get("year").value = education.data.year || "";
    }


    /* SKILLS */

    const skills = await db
        .from("skills")
        .select("*")
        .eq("portfolio_id", id);

    let skillText = "";

    if (skills.data) {
        for (let i = 0; i < skills.data.length; i++) {
            if (i > 0) {
                skillText += ", ";
            }

            skillText += skills.data[i].skill_name;
        }
    }

    get("skills").value = skillText;


    /* PROJECT */

    const project = await db
        .from("projects")
        .select("*")
        .eq("portfolio_id", id)
        .maybeSingle();

    if (project.data) {
        get("projectTitle").value = project.data.title || "";
        get("projectDescription").value =
            project.data.description || "";
        get("projectLink").value = project.data.link || "";
    }


    /* EXPERIENCE */

    const experience = await db
        .from("experiences")
        .select("*")
        .eq("portfolio_id", id)
        .maybeSingle();

    if (experience.data) {
        get("organization").value =
            experience.data.organization || "";

        get("position").value =
            experience.data.position || "";

        get("experienceDescription").value =
            experience.data.description || "";
    }
}


/* MANAGE PAGE */

async function loadManage() {
    const portfolio = await getPortfolio();

    const manageName = get("manageName");
    const templateRow = get("templateRow");
    const templateName = get("templateName");
    const portfolioStatus = get("portfolioStatus");
    const manageActions = get("manageActions");
    const viewPortfolio = get("viewPortfolio");

    if (!portfolio) {
        manageName.textContent = "No portfolio yet";

        portfolioStatus.textContent =
            "Create a portfolio to get started.";

        manageActions.innerHTML =
            '<a class="btn" href="portfolio-form.html">' +
            'Create Portfolio</a>';

        manageActions.style.display = "flex";

        return;
    }

    manageName.textContent = portfolio.full_name;

   if (portfolio.selected_template) {
    templateName.textContent =
        portfolio.selected_template.charAt(0).toUpperCase() +
        portfolio.selected_template.slice(1);
} else {
    templateName.textContent = "Not selected";
}

    portfolioStatus.textContent =
        "Portfolio saved online.";

    viewPortfolio.href =
        "portfolio.html?id=" + portfolio.id;

    templateRow.style.display = "block";
    manageActions.style.display = "flex";
}


/* DELETE PORTFOLIO */

async function deletePortfolio() {
    const portfolio = await getPortfolio();

    if (!portfolio) {
        return;
    }

    const confirmed = confirm(
        "Delete your portfolio? This cannot be undone."
    );

    if (!confirmed) {
        return;
    }

    const { error } = await db
        .from("portfolios")
        .delete()
        .eq("id", portfolio.id);

    if (error) {
        alert(error.message);
        return;
    }

    localStorage.removeItem(PORTFOLIO_ID);

    alert("Portfolio deleted successfully!");

    location.href = "index.html";
}


/* LOAD MANAGE PAGE */

if (get("managePage")) {
    loadManage();
}