let menue = [
    { name: "Home" },
    { name: "Kategorien" },
    { name: "Verkaufen" },
    {
        name: "Unternehmen",
        unterpunkte: [
            { name: "Philosophie" },
            { name: "Karriere" }
        ]
    }
];

function baueMenue(menueDaten) {
    let ul = document.createElement("ul");

    for (let i = 0; i < menueDaten.length; i++) {
        let li = document.createElement("li");
        li.textContent = menueDaten[i].name;

        if (menueDaten[i].unterpunkte) {
            let unterUl = document.createElement("ul");

            for (let j = 0; j < menueDaten[i].unterpunkte.length; j++) {
                let unterLi = document.createElement("li");
                unterLi.textContent = menueDaten[i].unterpunkte[j].name;
                unterUl.appendChild(unterLi);
            }

            li.appendChild(unterUl);
        }

        ul.appendChild(li);
    }

    return ul;
}

let menueContainer = document.getElementById("menu");
let menueHtml = baueMenue(menue);
menueContainer.appendChild(menueHtml);
