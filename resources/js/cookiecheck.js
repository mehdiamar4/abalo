"use strict";

function hasConsent() {
    return document.cookie.includes("cookieAccepted=true");
}

function setConsent() {
    document.cookie = "cookieAccepted=true; path=/; max-age=31536000; SameSite=Lax";
}

function createBanner() {
    if (!document.body.classList.contains("marketplace-page")) return;

    const banner = document.createElement("aside");
    banner.className = "cookie-notice";
    banner.setAttribute("aria-label", "Cookie-Hinweis");

    const icon = document.createElement("span");
    icon.textContent = "";
    icon.setAttribute("aria-hidden", "true");

    const copy = document.createElement("p");
    copy.innerHTML = "<strong>Cookie-Hinweis</strong>Abalo nutzt einen Cookie, um deine Auswahl zu speichern.";

    const button = document.createElement("button");
    button.type = "button";
    button.textContent = "Verstanden";
    button.addEventListener("click", () => {
        setConsent();
        banner.remove();
    });

    banner.append(icon, copy, button);
    document.body.appendChild(banner);
}

window.addEventListener("DOMContentLoaded", () => {
    if (!hasConsent()) createBanner();
});
