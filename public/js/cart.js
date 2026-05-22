"use strict";

let cart = [];

// add item
function addToCart(id, name) {

    // check duplicate
    if (cart.find(item => item.id === id)) {
        return;
    }

    cart.push({ id: id, name: name });
    renderCart();//Anzeige aktualisieren
}

// remove item
function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    renderCart();
}

// update UI
function renderCart() {
    let cartList = document.getElementById("cart");
    cartList.innerHTML = "";

    cart.forEach(item => {
        let li = document.createElement("li");

        li.innerHTML = `
            ${item.name}
            <button onclick="removeFromCart(${item.id})">-</button>
        `;

        cartList.appendChild(li);
    });
}
