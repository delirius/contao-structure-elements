# HTML Struktur Element für Contao

HTML Struktur Element erstellt jeweils ein Start- und ein Stop-Element anwendbar als **Inhaltselement** oder als **Formularelement**. Im Start-Element können HTML-Tag, ID, Klasse und eigene Attribute definiert werden.

Beim erstellen und speichern vom Start-Element wird automatisch das **Stop-Element generiert** und verknüpft. Die Elemente können wie gewohnt im Contao Backend verschoben, kopiert und als Inhaltselement platziert werden. Wird eine Element (Artikel, Seite, Formular) kopiert, werden die Elemente neu verknüpft. Wird ein Element gelöscht wird das dazugehörige Element ebenfalls gelöscht.

Die Erweiterung eignet sich zum abbilden von Strukturen einer Webseite wie Grid, Button, Card, Dropdown oder ähnliches. 


| Feld | Beschreibung |
| :--- | :--- |
| Titel | Wird für die Darstellung im Backend verwendet |
| Farbe | Wird für die Darstellung im Backend verwendet |
| HTML-Tag | HTML Element wie `div`, `span`, `button`, `a`, etc. Erlaubt sind HTML-Tags gemäss den Contao-Einstellungen siehe [Sicherheit](#sicherheit ).|
| ID | Standard Feld `id` (nur bei Inhaltselementen verfügbar) |
| Klasse | Standard Feld `class` |
| HTML-Attribute | Ergänzende Attribute wie `data-*`, `aria-*`, `title`, `href`, `style` |
| Inhalt | Reiner Text |

## Contao
Contao: ^4.13 oder ^5.0<br>
PHP:  ^8.1<br>

**Contao Inserttags** werden bei der Frontend-Ausgabe umgewandelt, wie `© {{date::Y}}`.<br>
**E-Mails** werden automatisch erkannt und in Unicode ausgegeben.<br>


## Sicherheit
Um die Sicherheit zu gewährleisten, werden bei der **Frontend-Ausgabe** die HTML-Tags **gefiltert**, gemäss den Contao-Einstellungen für erlaubte HTML-Tags und erlaubte HTML-Attribute. Wenn nötig, müssen spezielle HTML-Tags und HTML-Attribute in den Einstellungen -> Sicherheitseinstellungen hinzugefügt werden.

Beispiel Konfiguration

Erlaubte HTML-Tags: 
```
<iframe>
```
Erlaubte HTML-Attribute:
```
iframe | src,style,allowfullscreen
button | type,disabled
a | type,role
```



## Screenshots

### Eingabemaske
![Alt text](docs/structure_start.png?raw=true "Structure element start")

### Darstellung Contao Backend
![Alt text](docs/structure_start_buttonbackend.png?raw=true "Structure element backend")

### Beispiel Grid
![Alt text](docs/structure_start_grid.png?raw=true "Structure element grid")

### Beispiel Formular
![Alt text](docs/structure_start_formularbackend.png?raw=true "Structure element formular")

### Beispiel Inserttag
![Alt text](docs/inserttags.png?raw=true "Structure element inserttag")

### Beispiel Offcanvas
![Alt text](docs/offcanvas.png?raw=true "Structure element offcanvas")


