function toggleTheme() {
    const currentTheme = document.body.classList.contains("dark") ? "light" : "dark";
    document.body.classList.remove("light", "dark");
    document.body.classList.add(currentTheme);
    document.cookie = "theme=" + currentTheme + ";path=/;max-age=31536000";
}

function loadThemeFromCookie() {
    const cookies = document.cookie.split(";");
    for (const cookie of cookies) {
        const [name, value] = cookie.trim().split("=");
        if (name === "theme") {
            document.body.classList.add(value);
            return;
        }
    }
    document.body.classList.add("light");
}

function setupAccordion() {
    const buttons = document.querySelectorAll(".accordion-button");
    buttons.forEach(button => {
        button.addEventListener("click", () => {
            const content = button.nextElementSibling;
            content.style.display = (content.style.display === "block") ? "none" : "block";
        });
    });
}

window.addEventListener("DOMContentLoaded", () => {
    loadThemeFromCookie();
    setupAccordion();
});
