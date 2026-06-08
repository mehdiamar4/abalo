"use strict";

window.onload = function () {
    let container = document.getElementById("form-container");

    let nameInput = document.createElement("input");
    nameInput.placeholder = "Name";

    let priceInput = document.createElement("input");
    priceInput.placeholder = "Price";

    let descInput = document.createElement("input");
    descInput.placeholder = "Description";

    let button = document.createElement("button");
    button.type = "button";
    button.innerText = "Save";

    button.addEventListener("click", function () {
        if (!nameInput.value || priceInput.value <= 0) {
            document.getElementById("result").innerText =
                "Fehler: Name required and price must be > 0";
            return;
        }

        let formData = new FormData();
        formData.append("name", nameInput.value);
        formData.append("price", priceInput.value);
        formData.append("description", descInput.value);

        let token = document.querySelector('meta[name="csrf-token"]').content;

        fetch("/articles", {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "X-CSRF-TOKEN": token,
                "Accept": "text/plain"
            },
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                document.getElementById("result").innerText = data;
            })
            .catch(err => {
                document.getElementById("result").innerText =
                    "Netzwerkfehler: " + err;
            });
    });

    container.appendChild(nameInput);
    container.appendChild(document.createElement("br"));
    container.appendChild(priceInput);
    container.appendChild(document.createElement("br"));
    container.appendChild(descInput);
    container.appendChild(document.createElement("br"));
    container.appendChild(button);
};
