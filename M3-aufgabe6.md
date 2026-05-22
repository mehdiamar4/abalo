Engine-Zuordnung: V8 = Chrome/Edge/Node, SpiderMonkey = Firefox, JavaScriptCore = Safari.
1. Set-Methoden (intersection usw.) — von allen drei unterstützt, seit Mitte 2024.  Einsetzbar.
2. Temporal — nur Chrome/Edge (V8) und Firefox (SpiderMonkey). Safari fehlt noch.  Noch nicht, solange Safari unterstützt werden muss.
3. Static Blocks (static { }) — von allen drei unterstützt, schon seit 2023.  Einsetzbar.
4. Decorators (@decorator) — von keiner Engine nativ unterstützt, nur über Babel/TypeScript. Nicht einsetzen.
5. Array grouping — wichtig: heißt nicht mehr Array.prototype.group, sondern Object.groupBy(). Unter dem neuen Namen von allen drei unterstützt. ✅ Einsetzbar.
   Meine Entscheidung zum Erklären:
   Einsetzen würde ich Set-Methoden, Static Blocks und Object.groupBy — die laufen überall stabil. Temporal noch nicht, weil Safari es noch nicht kann. Decorators nicht, weil keine Engine sie nativ unterstützt und wir dafür einen Build-Schritt bräuchten, den wir nicht haben.
   Quellen: MDN Web Docs, web.dev, v8.dev und das TC39-GitHub.
   So kannst du es flüssig vortragen. Der eine Punkt, mit dem du beim Prof punkten kannst: dass Array.prototype.group umbenannt wurde zu Object.groupBy — das zeigt, dass du wirklich recherchiert und nicht nur abgeschrieben hast.Opus 4.7
