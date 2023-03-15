# Struktur Element für Contao
This bundle is still under construction.

Struktur Element für Contao erstellt jeweils ein Start und ein Stop Element als Inhaltselement oder als Formularelement. Es kann ein HTML-Element mit ID, Klasse, Attribute definiert werden.

Die Erweiterung eignet sich zum abbilden von Strukturen einer Webseite wie Grid, Button, Card, Dropdown oder ähnliches. Die Elemente können wie gewohnt im Contao Backend verschoben, kopiert und als Inhaltselement platziert werden.

Beim erstellen und speichern vom Start Element wird automatisch das Stop Element generiert und verknüpft. Wird eine Element (Artikel, Seite, Formular) kopiert, werden die Elemente neu verknüpft. Wird ein Element gelöscht wird das dazugehörige Element ebenfalls gelöscht.

## Sicherheit
Die HTML-Elemente werden bei der **Frontend-Ausgabe** gemäss den Contao Einstellungen **gefiltert** (Erlaubte HTML-Tags, Erlaubte HTML-Attribute). Möchte man spezielle HTML-Tags wie iframe oder script ausgeben, müssen diese in den Contao Einstellungen erfasst werden.

```
Erlaubte HTML-Tags: <iframe>
Erlaubte HTML-Attribute: iframe - src,style,allowfullscreen
```

### Eingabemaske
![Alt text](docs/structure_start.png?raw=true "struture element start")

### Darstellung Contao Backend
![Alt text](docs/structure_start_grid.png?raw=true "struture element grid")


### Beispiel Offcanvas (Bootstrap 5)
![Alt text](docs/offcanvas.png?raw=true "offcanvas")


