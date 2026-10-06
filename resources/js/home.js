"use strict";

window.addEventListener("DOMContentLoaded", () => {
    const header = document.querySelector(".site-header");
    const navToggle = document.querySelector(".nav-toggle");
    const mobileNav = document.getElementById("mobile-nav");

    const updateHeader = () => header?.classList.toggle("scrolled", window.scrollY > 12);
    updateHeader();
    window.addEventListener("scroll", updateHeader, { passive: true });

    navToggle?.addEventListener("click", () => {
        const isOpen = navToggle.getAttribute("aria-expanded") === "true";
        navToggle.setAttribute("aria-expanded", String(!isOpen));
        navToggle.setAttribute("aria-label", isOpen ? "Menü öffnen" : "Menü schließen");
        if (mobileNav) mobileNav.hidden = isOpen;
    });

    mobileNav?.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", () => {
            mobileNav.hidden = true;
            navToggle?.setAttribute("aria-expanded", "false");
        });
    });

});
