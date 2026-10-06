const homePortfolioButton = document.getElementById("homePortfolioButton");
const portfolioId = localStorage.getItem("portfolio_id");

if (portfolioId) {
    homePortfolioButton.textContent = "My Portfolio";
    homePortfolioButton.href = `portfolio.html?id=${portfolioId}`;
}
