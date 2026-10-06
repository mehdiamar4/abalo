"use strict";

let shoppingCartId = localStorage.getItem("shoppingCartId") || null;
let toastTimer;

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || "";
}

function formatPrice(value) {
    return new Intl.NumberFormat("de-DE", {
        style: "currency",
        currency: "EUR",
    }).format(Number(value));
}

function showToast(message) {
    const toast = document.getElementById("cart-toast");
    if (!toast) return;

    toast.textContent = message;
    toast.classList.add("visible");
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove("visible"), 2600);
}

function setDrawer(open) {
    const drawer = document.getElementById("cart-drawer");
    const backdrop = document.querySelector(".drawer-backdrop");
    if (!drawer || !backdrop) return;

    drawer.classList.toggle("open", open);
    drawer.setAttribute("aria-hidden", String(!open));
    backdrop.hidden = false;
    requestAnimationFrame(() => backdrop.classList.toggle("open", open));
    document.body.classList.toggle("drawer-open", open);

    if (!open) setTimeout(() => { backdrop.hidden = true; }, 260);
}

window.addToCart = async function (id, name) {
    const formData = new FormData();
    formData.append("articleid", id);

    try {
        const response = await fetch("/api/shoppingcart", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": getCsrfToken(),
                Accept: "application/json",
            },
            body: formData,
        });
        if (!response.ok) throw new Error("Artikel konnte nicht hinzugefügt werden.");

        const data = await response.json();
        if (data.shoppingcartid) {
            shoppingCartId = data.shoppingcartid;
            localStorage.setItem("shoppingCartId", shoppingCartId);
            await loadCart();
            showToast(`${name} ist jetzt in deinem Warenkorb.`);
        }
    } catch (error) {
        showToast(error.message);
    }
};

async function removeFromCart(id) {
    if (!shoppingCartId) return;

    try {
        const response = await fetch(`/api/shoppingcart/${shoppingCartId}/articles/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": getCsrfToken(),
                Accept: "application/json",
            },
        });
        if (!response.ok) throw new Error("Artikel konnte nicht entfernt werden.");
        await loadCart();
    } catch (error) {
        showToast(error.message);
    }
}

async function loadCart() {
    if (!shoppingCartId) {
        renderCart([]);
        return;
    }

    try {
        const response = await fetch(`/api/shoppingcart/${shoppingCartId}`, {
            headers: { Accept: "application/json" },
        });
        if (!response.ok) throw new Error("Warenkorb konnte nicht geladen werden.");
        const data = await response.json();
        renderCart(data.items || []);
    } catch (error) {
        renderCart([]);
        console.error(error);
    }
}

function renderCart(items) {
    const cartList = document.getElementById("cart");
    const cartCount = document.getElementById("cart-count");
    const emptyState = document.getElementById("cart-empty");

    if (cartCount) cartCount.textContent = String(items.length);
    if (emptyState) emptyState.classList.toggle("visible", items.length === 0);
    if (!cartList) return;

    cartList.innerHTML = "";
    items.forEach((item) => {
        const listItem = document.createElement("li");
        listItem.className = "cart-item";

        const image = document.createElement("img");
        image.src = `/images/${item.id}.jpg`;
        image.alt = "";
        image.addEventListener("error", () => {
            if (!image.src.endsWith(".png")) image.src = image.src.replace(".jpg", ".png");
        });

        const copy = document.createElement("div");
        copy.className = "cart-item-copy";
        const title = document.createElement("strong");
        title.textContent = item.name;
        const price = document.createElement("span");
        price.textContent = formatPrice(item.price);
        copy.append(title, price);

        const removeButton = document.createElement("button");
        removeButton.type = "button";
        removeButton.className = "cart-remove";
        removeButton.textContent = "×";
        removeButton.setAttribute("aria-label", `${item.name} entfernen`);
        removeButton.addEventListener("click", () => removeFromCart(item.id));

        listItem.append(image, copy, removeButton);
        cartList.appendChild(listItem);
    });
}

window.addEventListener("DOMContentLoaded", () => {
    document.querySelector(".cart-trigger")?.addEventListener("click", () => setDrawer(true));
    document.querySelectorAll("[data-cart-close]").forEach((element) => {
        element.addEventListener("click", () => setDrawer(false));
    });
    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") setDrawer(false);
    });
    loadCart();
});
