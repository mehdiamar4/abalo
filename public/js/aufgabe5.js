function getMaxPreis(data) {
    let maxProdukt = data.produkte[0];

    for (let i = 1; i < data.produkte.length; i++) {
        if (data.produkte[i].preis > maxProdukt.preis) {
            maxProdukt = data.produkte[i];
        }
    }

    return maxProdukt.name;
}

function getMinPreisProdukt(data) {
    let minProdukt = data.produkte[0];

    for (let i = 1; i < data.produkte.length; i++) {
        if (data.produkte[i].preis < minProdukt.preis) {
            minProdukt = data.produkte[i];
        }
    }

    return minProdukt;
}

function getPreisSum(data) {
    let summe = 0;

    for (let i = 0; i < data.produkte.length; i++) {
        summe = summe + data.produkte[i].preis;
    }

    return summe;
}

function getGesamtWert(data) {
    let gesamtwert = 0;

    for (let i = 0; i < data.produkte.length; i++) {
        gesamtwert = gesamtwert + (data.produkte[i].preis * data.produkte[i].anzahl);
    }

    return gesamtwert;
}

function getAnzahlProdukteOfKategorie(data, kategoriename) {
    let kategorieId = -1;

    for (let i = 0; i < data.kategorien.length; i++) {
        if (data.kategorien[i].name === kategoriename) {
            kategorieId = data.kategorien[i].id;
        }
    }

    let anzahl = 0;

    for (let i = 0; i < data.produkte.length; i++) {
        if (data.produkte[i].kategorie === kategorieId) {
            anzahl = anzahl + data.produkte[i].anzahl;
        }
    }

    return anzahl;
}

console.log(getMaxPreis(data));
console.log(getMinPreisProdukt(data));
console.log(getPreisSum(data));
console.log(getGesamtWert(data));
console.log(getAnzahlProdukteOfKategorie(data, "Spielzeug"));
console.log(getAnzahlProdukteOfKategorie(data, "Garten"));

document.getElementById("maxPreis").innerText =
    "Max Preis Produkt: " + getMaxPreis(data);

document.getElementById("minPreis").innerText =
    "Min Preis Produkt: " + JSON.stringify(getMinPreisProdukt(data));

document.getElementById("preisSumme").innerText =
    "Preis Summe: " + getPreisSum(data);

document.getElementById("gesamtWert").innerText =
    "Gesamtwert: " + getGesamtWert(data);

document.getElementById("spielzeugAnzahl").innerText =
    "Anzahl Spielzeug: " + getAnzahlProdukteOfKategorie(data, "Spielzeug");

document.getElementById("gartenAnzahl").innerText =
    "Anzahl Garten: " + getAnzahlProdukteOfKategorie(data, "Garten");
