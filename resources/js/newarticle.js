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
                categoryId: "",
                message: "",
                success: false,
                saving: false
            };
        },

        methods: {
            saveArticle() {
                let roundedPrice = round(Number(this.price), 2);

                this.success = false;

                if (!this.name || roundedPrice <= 0 || !this.categoryId || !this.description) {
                    this.message = "Bitte fülle alle Felder vollständig aus.";
                    return;
                }

                this.saving = true;

                let formData = new FormData();
                formData.append("name", this.name);
                formData.append("price", roundedPrice);
                formData.append("description", this.description);
                formData.append("category_id", this.categoryId);

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
                    .then(async response => {
                        const data = await response.json();
                        if (!response.ok) {
                            throw new Error(data.error || "Der Artikel konnte nicht gespeichert werden.");
                        }
                        return data;
                    })
                    .then(() => {
                        this.message = "Der Artikel wurde veröffentlicht.";
                        this.success = true;

                        this.name = "";
                        this.price = "";
                        this.description = "";
                        this.categoryId = "";
                    })
                    .catch(err => {
                        this.success = false;
                        this.message = err.message;
                    })
                    .finally(() => {
                        this.saving = false;
                    });
            }
        }
    }).mount("#new-article-app");
});
