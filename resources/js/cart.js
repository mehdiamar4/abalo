"use strict";

// Merkt sich die ID des Warenkorbs über Reloads hinweg
let shoppingCartId = localStorage.getItem("shoppingCartId") || null;

// CSRF-Token aus dem Meta-Tag
function getCsrfToken() {
    let meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.content : "";
}

// Artikel hinzufügen -> POST /api/shoppingcart
window.addToCart = function (id, name) {
    let formData = new FormData();
    formData.append("articleid", id);

    fetch("/api/shoppingcart", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": getCsrfToken(),
            "Accept": "application/json"
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.shoppingcartid) {
                shoppingCartId = data.shoppingcartid;
                localStorage.setItem("shoppingCartId", shoppingCartId);
                loadCart();
            }
        })
        .catch(err => console.error("Fehler beim Hinzufuegen:", err));
};

// Artikel entfernen -> DELETE /api/shoppingcart/{cartId}/articles/{articleId}
function removeFromCart(id) {
    if (!shoppingCartId) {
        return;
    }

    fetch("/api/shoppingcart/" + shoppingCartId + "/articles/" + id, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": getCsrfToken(),
            "Accept": "application/json"
        }
    })
        .then(response => response.json())
        .then(() => {
            loadCart();
        })
        .catch(err => console.error("Fehler beim Entfernen:", err));
}

// Warenkorb aus der DB laden -> GET /api/shoppingcart/{cartId}
function loadCart() {
    if (!shoppingCartId) {
        return;
    }

    fetch("/api/shoppingcart/" + shoppingCartId, {
        headers: {
            "Accept": "application/json"
        }
    })
        .then(response => response.json())
        .then(data => {
            renderCart(data.items || []);
        })
        .catch(err => console.error("Fehler beim Laden:", err));
}

// Anzeige aktualisieren
function renderCart(items) {
    let cartList = document.getElementById("cart");

    if (!cartList) {
        return;
    }

    cartList.innerHTML = "";

    items.forEach(item => {
        let li = document.createElement("li");
        li.textContent = item.name + " ";

        let button = document.createElement("button");
        button.textContent = "-";

        button.addEventListener("click", function () {
            removeFromCart(item.id);
        });

        li.appendChild(button);
        cartList.appendChild(li);
    });
}

// Beim Laden der Seite Warenkorb laden
window.addEventListener("load", function () {
    loadCart();
});
