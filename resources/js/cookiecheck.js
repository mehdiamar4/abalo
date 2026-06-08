"use strict";

// check if cookie exists
function hasConsent() {
    return document.cookie.includes("cookieAccepted=true");
}

// set cookie
function setConsent() {
    document.cookie = "cookieAccepted=true; path=/; max-age=31536000"; // 1 year
}

// create banner
function createBanner() {
    let banner = document.createElement("div");

    banner.style.position = "fixed";
    banner.style.bottom = "0";
    banner.style.width = "100%";
    banner.style.background = "#ccc";
    banner.style.padding = "10px";
    banner.style.textAlign = "center";

    banner.innerHTML = `
        This website uses cookies.
        <button id="acceptCookies">Accept</button>
    `;

    document.body.appendChild(banner);

    document.getElementById("acceptCookies").addEventListener("click", function () {
        setConsent();
        banner.remove();
    });
}

// run on page load
window.onload = function () {
    if (!hasConsent()) {
        createBanner();
    }
};
