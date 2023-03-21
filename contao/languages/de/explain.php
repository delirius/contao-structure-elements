<?php

declare (strict_types = 1);
// contao/languages/en/explain.php
$GLOBALS['TL_LANG']['XPL']['htmltag'] = [
	['colspan', '<h3>HTML-Tags</h3>
HTML Element wie `div`, `span`, `button`, `a` etc. Erlaubt sind HTML-Tags gemäss den Contao-Einstellungen'],
	['colspan', '<h3>Sicherheit</h3>
Um die Sicherheit zu gewährleisten, werden bei der <strong>Frontend-Ausgabe</strong> die HTML-Tags <strong>gefiltert</strong>, gemäss den Contao-Einstellungen für erlaubte HTML-Tags und erlaubte HTML-Attribute. Wenn nötig, müssen spezielle HTML-Tags und HTML-Attribute in den Einstellungen -> Sicherheitseinstellungen hinzugefügt werden.<br><br>Beispiel Konfiguration:'],
	['Erlaubte HTML-Tags:', '&lt;iframe&gt;'],
	['Erlaubte HTML-Attribute:', 'iframe | src,style,allowfullscreen <br>button | type,disabled <br>a | type,role'],
];
