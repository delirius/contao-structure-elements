<?php

declare (strict_types = 1);
// contao/languages/en/explain.php
$GLOBALS['TL_LANG']['XPL']['htmltag'] = [
	['colspan', '<h3>Security</h3>
To ensure security, HTML tags are <strong>filtered</strong> in the <strong>frontend output</strong> according to the Contao settings for allowed HTML tags and allowed HTML attributes. If necessary, special HTML tags and HTML attributes must be added in the Settings -> Security settings.<br><br>
Examples:', ],
	['Allowed HTML tags:', '&lt;iframe&gt;'],
	['Allowed HTML attributes:', 'iframe | src,style,allowfullscreen <br>button | type,disabled <br>a | type,role'],
];
