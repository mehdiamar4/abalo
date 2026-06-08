"use strict";

import { round } from "mathjs";

let shoppingCartId = localStorage.getItem("shoppingCartId") || null;

function getCsrfToken() {
    let meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.content : "";
}

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

function renderCart(items) {
    let cartList = document.getElementById("cart");

    if (!cartList) {
        return;
    }

    cartList.innerHTML = "";

    items.forEach(item => {
        let li = document.createElement("li");

        let text = item.name;

        if (item.price !== undefined && item.price !== null) {
            let euroPrice = round(Number(item.price) / 100, 2);
            text = text + " (" + euroPrice + " €)";
        }

        li.textContent = text + " ";

        let button = document.createElement("button");
        button.textContent = "-";

        button.addEventListener("click", function () {
            removeFromCart(item.id);
        });

        li.appendChild(button);
        cartList.appendChild(li);
    });
}

window.addEventListener("load", function () {
    loadCart();
});
