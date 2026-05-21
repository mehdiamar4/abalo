Aufgabe 7 – Analyse Webservices

API 1: GitHub REST API

1. Zweck der API:
   Die GitHub REST API dient zum Abrufen und Verwalten von GitHub-Daten. Man kann z.B. Repositories, Benutzer, Issues oder Pull Requests abfragen und bearbeiten.

2. Umgesetzte REST-Prinzipien:
   Die API nutzt Client-Server, arbeitet zustandslos und verwendet Ressourcen-URLs sowie HTTP-Methoden wie GET, POST, PATCH und DELETE.

3. Richardson Maturity Model:
   Die API befindet sich auf Level 2, da mehrere Ressourcen und HTTP-Methoden verwendet werden.

4. Versionierung:
   Die Versionierung erfolgt über HTTP-Header, z.B.:
   X-GitHub-Api-Version

API 2: OpenStreetMap Nominatim API

1. Zweck der API:
   Die Nominatim API dient zur Suche von Orten und Adressen mit OpenStreetMap-Daten. Außerdem können Koordinaten in Adressen umgewandelt werden.

2. Umgesetzte REST-Prinzipien:
   Die API verwendet eine Client-Server-Struktur, arbeitet zustandslos und nutzt Ressourcen-Endpunkte wie /search oder /reverse.

3. Richardson Maturity Model:
   Die API befindet sich ebenfalls auf Level 2, da mehrere Endpunkte und HTTP-Methoden genutzt werden.

4. Versionierung:
   Die API besitzt eine dokumentierte API-Version, jedoch nicht deutlich über /api/v1 im Pfad umgesetzt.
