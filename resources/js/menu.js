"use strict";

const Navigationsmenue = {

    punkte: [],

    addItem(name, unterpunkte = []) {
        this.punkte.push({ name: name, unterpunkte: unterpunkte });
        return this;
    },

    addSubItem(elternName, name) {
        for (let punkt of this.punkte) {
            if (punkt.name === elternName) {
                punkt.unterpunkte.push({ name: name });
                break;
            }
        }
        return this;
    },

    _baueListe(punkte) {
        let ul = document.createElement("ul");

        for (let punkt of punkte) {
            let li = document.createElement("li");
            li.textContent = punkt.name;

            if (punkt.unterpunkte && punkt.unterpunkte.length > 0) {
                li.appendChild(this._baueListe(punkt.unterpunkte));
            }

            ul.appendChild(li);
        }

        return ul;
    },

    render() {
        return this._baueListe(this.punkte);
    },

    mount(containerId) {
        let container = document.getElementById(containerId);
        container.innerHTML = "";
        container.appendChild(this.render());
        return this;
    }
};

window.addEventListener("load", function () {
    Navigationsmenue
        .addItem("Home")
        .addItem("Kategorien")
        .addItem("Verkaufen")
        .addItem("Unternehmen", [
            { name: "Philosophie" },
            { name: "Karriere" }
        ])
        .mount("menu");
});
