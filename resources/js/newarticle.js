"use strict";

import { createApp } from "vue/dist/vue.esm-bundler.js";
import { round } from "mathjs";

window.addEventListener("load", function () {
    let appElement = document.getElementById("new-article-app");

    if (!appElement) {
        return;
    }

    createApp({
        data() {
            return {
                name: "",
                price: "",
                description: "",
                message: ""
            };
        },

        methods: {
            saveArticle() {
                let roundedPrice = round(Number(this.price), 2);

                if (!this.name || roundedPrice <= 0) {
                    this.message = "Fehler: Name required and price must be > 0";
                    return;
                }

                let formData = new FormData();
                formData.append("name", this.name);
                formData.append("price", roundedPrice);
                formData.append("description", this.description);

                let token = document.querySelector('meta[name="csrf-token"]').content;

                fetch("/api/articles", {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json"
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            this.message = data.error;
                            return;
                        }

                        this.message = "Artikel wurde erfolgreich erstellt.";

                        this.name = "";
                        this.price = "";
                        this.description = "";
                    })
                    .catch(err => {
                        this.message = "Netzwerkfehler: " + err;
                    });
            }
        }
    }).mount("#new-article-app");
});
