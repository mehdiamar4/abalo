Frage 1: Was passiert, wenn sehr viele Benutzer:innen gleichzeitig die Lösung verwenden?
Bei unserer Lösung wird bei jeder Zeicheneingabe ab 3 Zeichen sofort eine Anfrage an den Server geschickt. Wenn viele Nutzer gleichzeitig tippen, bekommt der Server sehr viele Anfragen auf einmal. Das kann den Server verlangsamen oder im schlimmsten Fall zum Absturz führen, weil die Datenbank bei jeder Anfrage eine Suche durchführen muss.
Eine Verbesserung wäre ein sogenanntes Debounce, also eine kurze Wartezeit von z.B. 300ms nach dem letzten Tastendruck, bevor die Anfrage gesendet wird. So werden deutlich weniger Anfragen geschickt.

Frage 2: Wie verhält sich die Suche, wenn der Benutzer seine Eingabe sehr schnell mehrfach hintereinander anpasst?
Wenn der Nutzer sehr schnell tippt, werden mehrere Anfragen gleichzeitig gesendet. Das Problem ist, dass eine ältere Anfrage manchmal später beim Browser ankommt als eine neuere. Dadurch können falsche oder veraltete Ergebnisse angezeigt werden.
Eine Lösung wäre, alte Anfragen mit einem sogenannten AbortController abzubrechen, sobald eine neue Anfrage gestartet wird. Zusammen mit Debounce würde die Suche dann zuverlässig und stabil funktionieren.


