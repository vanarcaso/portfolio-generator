const homePortfolioButton =
    document.getElementById("homePortfolioButton");


async function updateHomeButton() {

    if (!homePortfolioButton) {
        return;
    }

    /* HIDE BUTTON WHILE CHECKING */

    homePortfolioButton.style.visibility = "hidden";


    const portfolioId =
        localStorage.getItem("portfolio_id");


    /* NO PORTFOLIO */

    if (!portfolioId) {

        homePortfolioButton.textContent =
            "Create Portfolio";

        homePortfolioButton.setAttribute(
            "href",
            "portfolio-form.html"
        );

        homePortfolioButton.style.visibility = "visible";

        return;
    }


    /* CHECK PORTFOLIO IN SUPABASE */

    const { data, error } = await db
        .from("portfolios")
        .select("selected_template")
        .eq("id", portfolioId)
        .maybeSingle();


    /* PORTFOLIO DOES NOT EXIST */

    if (error || !data) {

        localStorage.removeItem("portfolio_id");

        homePortfolioButton.textContent =
            "Create Portfolio";

        homePortfolioButton.setAttribute(
            "href",
            "portfolio-form.html"
        );

        homePortfolioButton.style.visibility = "visible";

        return;
    }


    /* PORTFOLIO ALREADY HAS TEMPLATE */

    if (data.selected_template) {

        homePortfolioButton.textContent =
            "My Portfolio";

        homePortfolioButton.setAttribute(
            "href",
            "portfolio.html?id=" + portfolioId
        );

    }


    /* PORTFOLIO EXISTS BUT NO TEMPLATE */

    else {

        homePortfolioButton.textContent =
            "Continue Portfolio";

        homePortfolioButton.setAttribute(
            "href",
            "templates.html"
        );

    }


    homePortfolioButton.style.visibility = "visible";
}


updateHomeButton();
