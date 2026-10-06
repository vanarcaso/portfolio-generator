const homePortfolioButton = document.getElementById("homePortfolioButton");
const portfolioId = localStorage.getItem("portfolio_id");

async function updateHomeButton() {

    if (!homePortfolioButton || !portfolioId) {
        return;
    }

    const { data, error } = await db
        .from("portfolios")
        .select("selected_template")
        .eq("id", portfolioId)
        .maybeSingle();

    if (error || !data) {
        localStorage.removeItem("portfolio_id");
        return;
    }

    if (data.selected_template) {
        homePortfolioButton.textContent = "My Portfolio";
        homePortfolioButton.href = `portfolio.html?id=${portfolioId}`;
    } else {
        homePortfolioButton.textContent = "Continue Portfolio";
        homePortfolioButton.href = "templates.html";
    }
}

updateHomeButton();
