# Struktur Element für Contao

Struktur Element für Contao erstellt jeweils ein Start- und ein Stop-Element anwendbar als Inhaltselement oder als Formularelement. Im Start-Element können HTML-Tag, ID, Klasse und eigene Attribute definiert werden.

Beim erstellen und speichern vom Start-Element wird automatisch das Stop-Element generiert und verknüpft. Wird eine Element (Artikel, Seite, Formular) kopiert, werden die Elemente neu verknüpft. Wird ein Element gelöscht wird das dazugehörige Element ebenfalls gelöscht.

Die Erweiterung eignet sich zum abbilden von Strukturen einer Webseite wie Grid, Button, Card, Dropdown oder ähnliches. Die Elemente können wie gewohnt im Contao Backend verschoben, kopiert und als Inhaltselement platziert werden.


| Feld | Beschreibung |
| :--- | :--- |
| Titel | Wird für die Darstellung im Backend verwendet |
| Farbe | Wird für die Darstellung im Backend verwendet |
| HTML-Tag | Erlaubt sind HTML-Tags gemäss den Contao-Einstellungen |
| ID | Standard Feld id (nur in Inhaltselementen verfügbar) |
| Klasse | Standard Feld class |
| HTML-Attribute | Ergänzende Attribute wie type, data-*, aria-* |
| Inhalt | Reiner Text |

## Sicherheit
Um die Sicherheit zu gewährleisten, werden bei der **Frontend-Ausgabe** die HTML-Elemente **gefiltert**, gemäss den Contao-Einstellungen für erlaubte HTML-Tags und erlaubte HTML-Attribute. Wenn nötig, müssen spezielle HTML-Tags und HTML-Attribute in den Einstellungen hinzugefügt werden.

Erlaubte HTML-Tags: 
```
<iframe>
```
Erlaubte HTML-Attribute:
```
iframe | src,style,allowfullscreen
button | disabled
```
E-Mails werden automatisch verschlüsselt ausgegeben.


## Screenshots

### Eingabemaske
![Alt text](docs/structure_start.png?raw=true "struture element start")

### Darstellung Contao Backend
![Alt text](docs/structure_start_grid.png?raw=true "struture element grid")


### Beispiel Offcanvas (Bootstrap 5)
![Alt text](docs/offcanvas.png?raw=true "offcanvas")


