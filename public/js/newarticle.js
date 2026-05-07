"use strict";

window.onload = function () {

    let container = document.getElementById("form-container");

    let form = document.createElement("form");
    form.method = "POST";
    form.action = "/articles";

    // name
    let nameInput = document.createElement("input");
    nameInput.name = "name";
    nameInput.placeholder = "Name";

    // price
    let priceInput = document.createElement("input");
    priceInput.name = "price";
    priceInput.placeholder = "Price";

    // description
    let descInput = document.createElement("input");
    descInput.name = "description";
    descInput.placeholder = "Description";

    // submit button
    let button = document.createElement("button");
    button.innerText = "Save";

    // validation
    button.onclick = function (e) {
        if (!nameInput.value || priceInput.value <= 0) {
            alert("Name required and price must be > 0");
            e.preventDefault();
        }
    };

    form.appendChild(nameInput);
    form.appendChild(document.createElement("br"));

    form.appendChild(priceInput);
    form.appendChild(document.createElement("br"));

    form.appendChild(descInput);
    form.appendChild(document.createElement("br"));

    form.appendChild(button);

    container.appendChild(form);
};
